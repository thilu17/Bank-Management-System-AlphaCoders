<?php

namespace App\Libraries;

use DateTime;
use InvalidArgumentException;

class FdInterestCalculator
{
    // පොලී වර්ග
    public const SIMPLE   = 'simple';
    public const COMPOUND = 'compound';

    // දවස් ගණන් කරන ක්‍රම (day-count conventions)
    public const ACTUAL_365    = 'actual/365';
    public const ACTUAL_ACTUAL = 'actual/actual';
    public const THIRTY_360    = '30/360';

    // ---------- 1. Leap year සහ දවස් ගණන ----------

    public function isLeapYear(int $year): bool
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }

    public function daysBetween(string $start, string $end): int
    {
        $s = new DateTime($start);
        $e = new DateTime($end);

        if ($e < $s) {
            throw new InvalidArgumentException('End date must be after start date.');
        }

        return (int) $s->diff($e)->days;
    }

    /**
     * අවුරුදු කොටස (year fraction) ගණනය කරනවා, convention එක අනුව.
     */
    public function yearFraction(string $start, string $end, string $convention = self::ACTUAL_365): float
    {
        $s = new DateTime($start);
        $e = new DateTime($end);

        if ($e < $s) {
            throw new InvalidArgumentException('End date must be after start date.');
        }

        switch ($convention) {
            case self::ACTUAL_365:
                return $this->daysBetween($start, $end) / 365;

            case self::THIRTY_360:
                $d1 = min((int) $s->format('j'), 30);
                $d2 = (int) $e->format('j');
                if ($d2 === 31 && $d1 === 30) {
                    $d2 = 30;
                }
                $days = 360 * ((int) $e->format('Y') - (int) $s->format('Y'))
                      + 30 * ((int) $e->format('n') - (int) $s->format('n'))
                      + ($d2 - $d1);
                return $days / 360;

            case self::ACTUAL_ACTUAL:
                return $this->actualActualFraction($s, $e);

            default:
                throw new InvalidArgumentException("Unknown day-count convention: {$convention}");
        }
    }

    // අවුරුදු වෙන වෙනම බලලා 365 හෝ 366 න් බෙදනවා (leap year handle වෙනවා)
    private function actualActualFraction(DateTime $s, DateTime $e): float
    {
        $fraction  = 0.0;
        $startYear = (int) $s->format('Y');
        $endYear   = (int) $e->format('Y');

        for ($year = $startYear; $year <= $endYear; $year++) {
            $segStart = ($year === $startYear) ? clone $s : new DateTime("{$year}-01-01");
            $segEnd   = ($year === $endYear) ? clone $e : new DateTime(($year + 1) . '-01-01');
            $days     = (int) $segStart->diff($segEnd)->days;
            $fraction += $days / ($this->isLeapYear($year) ? 366 : 365);
        }

        return $fraction;
    }

    // ---------- 2. පොලී ගණනය ----------

    public function simpleInterest(float $principal, float $ratePercent, float $yearFraction): float
    {
        return round($principal * ($ratePercent / 100) * $yearFraction, 2);
    }

    public function compoundInterest(
        float $principal,
        float $ratePercent,
        float $yearFraction,
        int $timesPerYear = 4
    ): float {
        if ($timesPerYear < 1) {
            throw new InvalidArgumentException('Compounding frequency must be at least 1.');
        }

        $amount = $principal * pow(1 + ($ratePercent / 100) / $timesPerYear, $timesPerYear * $yearFraction);

        return round($amount - $principal, 2);
    }

    public function calculateInterest(
        float $principal,
        float $ratePercent,
        string $start,
        string $end,
        string $type = self::SIMPLE,
        string $convention = self::ACTUAL_365,
        int $timesPerYear = 4
    ): float {
        $this->validate($principal, $ratePercent);
        $fraction = $this->yearFraction($start, $end, $convention);

        if ($type === self::COMPOUND) {
            return $this->compoundInterest($principal, $ratePercent, $fraction, $timesPerYear);
        }
        if ($type === self::SIMPLE) {
            return $this->simpleInterest($principal, $ratePercent, $fraction);
        }

        throw new InvalidArgumentException("Unknown interest type: {$type}");
    }

    /**
     * අද වන විට (asOfDate) උපයාගත් පොලිය. Maturity date එකෙන් පස්සේ වැඩි වෙන්නේ නෑ.
     */
    public function accruedInterest(
        float $principal,
        float $ratePercent,
        string $start,
        string $maturityDate,
        string $asOfDate,
        string $type = self::SIMPLE,
        string $convention = self::ACTUAL_365,
        int $timesPerYear = 4
    ): float {
        $asOf = new DateTime($asOfDate);

        if ($asOf <= new DateTime($start)) {
            return 0.0;
        }
        if ($asOf > new DateTime($maturityDate)) {
            $asOfDate = $maturityDate;
        }

        return $this->calculateInterest($principal, $ratePercent, $start, $asOfDate, $type, $convention, $timesPerYear);
    }

    // ---------- 3. Maturity preview (FD හදන්න කලින් බලන්න) ----------

    public function maturityDate(string $start, int $tenureMonths): string
    {
        $date = new DateTime($start);
        $day  = (int) $date->format('j');

        $date->modify('first day of this month');
        $date->modify("+{$tenureMonths} months");
        $date->setDate((int) $date->format('Y'), (int) $date->format('n'), min($day, (int) $date->format('t')));

        return $date->format('Y-m-d');
    }

    public function previewMaturity(
        float $principal,
        float $ratePercent,
        int $tenureMonths,
        string $startDate,
        string $type = self::SIMPLE,
        string $convention = self::ACTUAL_365,
        int $timesPerYear = 4
    ): array {
        $maturity = $this->maturityDate($startDate, $tenureMonths);
        $interest = $this->calculateInterest($principal, $ratePercent, $startDate, $maturity, $type, $convention, $timesPerYear);

        return [
            'principal'       => round($principal, 2),
            'rate_percent'    => $ratePercent,
            'start_date'      => $startDate,
            'maturity_date'   => $maturity,
            'tenure_months'   => $tenureMonths,
            'days'            => $this->daysBetween($startDate, $maturity),
            'interest_type'   => $type,
            'day_count'       => $convention,
            'interest_earned' => $interest,
            'maturity_amount' => round($principal + $interest, 2),
        ];
    }

    private function validate(float $principal, float $ratePercent): void
    {
        if ($principal <= 0) {
            throw new InvalidArgumentException('Principal must be greater than zero.');
        }
        if ($ratePercent < 0) {
            throw new InvalidArgumentException('Interest rate cannot be negative.');
        }
    }
}