<?php
declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class PaymentDateGenerator
{
    const COLUMNS = ['Month', 'Salary Date', 'Bonus Date'];

    /**
     * 
     * @param string filename 
     */
    public function __construct(string $filename) {
        if ($this->isUrl($filename)) {
            throw new InvalidArgumentException('Only local file writing is supported');
        }
        $info = pathinfo($filename);
        $dir = realpath($info['dirname']);
        if (!$dir) {
            throw new InvalidArgumentException('Directory does not exist');
        }
        if (!is_writeable($dir)) {
            throw new InvalidArgumentException('Directory is not writeable');
        }
        if (file_exists($filename) && !is_writable($filename)) {
            throw new InvalidArgumentException('File is not writeable');
        }
        $this->file = fopen($filename, 'w+');
        if (!$this->file) {
            throw new Exception('Could not open file for writing');
        }
    }

    /**
     * Determine if given filename may be a url
     * 
     * returns true when an apparent scheme is present
     * @return bool
     */
    public function isUrl($filename) : bool {
        $info = parse_url($filename);
        if(isset($info['scheme'])) {
            return true;
        }
        return false;
    }

    /**
     * Run the processor
     */
    public function run() : void {
        fputcsv($this->file, self::COLUMNS);
        $month = (int) date('m');
        for (; $month <= 12; $month++) {
            $salaryDate = DateCalculator::getSalaryDateForMonth($month);
            $bonusDate = DateCalculator::getBonusDateForMonth($month);
            fputcsv($this->file, [$salaryDate->format('F'), $salaryDate->format('j'), $bonusDate->format('j')]);
        }
    }
}