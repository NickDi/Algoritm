<?php


class SolutionsFlags
{
    public const A = [1, 2];
//    public const A = [1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2];


 //   public const A = [1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2, 1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2];

    /**
     * @var int
     */
    public $minDiffBetweenPicks;

    public $maxFlagCount;
    /**
     * @param string[] $heights
     *
     */
    public function solution(array $heights): void
    {
        if (count($heights) < 3){
            print_r(0);
            return;
        }

        $this->maxFlagCount = round(sqrt(count($heights)),0,PHP_ROUND_HALF_DOWN);
        $this->minDiffBetweenPicks =$this->maxFlagCount;

        $pics = $this->getPics($heights);
        $pics = $this->setLengths($pics);
        print_r($pics);
//        var_dump($this->minDiffBetweenPicks);
        $result = $this->findMaxFlagCount($pics);

        print_r($result);
    }

    /**
     * @param array<int> $heights
     * @return array<int, bool>
     */
    private function getPics(array $heights): array
    {
        $lastIndexPic = count($heights)-1;
        $pics = [
            0 => true,
            $lastIndexPic => true
        ];

        for ($indexPoint = 1; $indexPoint < $lastIndexPic; $indexPoint++) {
            if (true === $this->isPic($heights, $indexPoint)) {
                unset($pics[$indexPoint-1], $pics[$indexPoint+1]);

                $pics[$indexPoint] = $this->canSetFlag();
            }
        }

        return $pics;
    }

    private function isPic($heights, $indexPoint): bool
    {
        return $heights[$indexPoint - 1] < $heights[$indexPoint] &&
            $heights[$indexPoint] > $heights[$indexPoint + 1];
    }

    private function canSetFlag(): bool
    {
        return false;
    }

    private function findMaxFlagCount(array $pics)
    {
        $maxDiffBetweenPicks = count($pics);
        if ($maxDiffBetweenPicks == $this->minDiffBetweenPicks){
            return $maxDiffBetweenPicks;
        }

        $maxCountOfFlags = $this->minDiffBetweenPicks;


        for($flagsCountVariant = $this->minDiffBetweenPicks; $flagsCountVariant <= $maxDiffBetweenPicks; $flagsCountVariant++){

            $currentCounter = 1;
            foreach ($pics as $picLength){
                if ($currentCounter > $flagsCountVariant){
                    continue;
                }

                if ($picLength < $flagsCountVariant){
                    continue;
                }
                $currentCounter++;
            }

            if ($maxCountOfFlags < $currentCounter){
                $maxCountOfFlags = $currentCounter;
            }


        }

        return $maxCountOfFlags;

    }


    private function setLengths(array $pics)
    {
        $keys = array_keys($pics);
        $keysReverse = array_reverse($keys);

        $prevIndex = $keysReverse[0];
        foreach ($keysReverse as $index){
            $pics[$index] = $prevIndex-$index;
            if ($prevIndex-$index < $this->minDiffBetweenPicks && $prevIndex-$index != 0){
                $this->minDiffBetweenPicks =$prevIndex-$index ;
            }

            $prevIndex = $index;
        }

        return $pics;
    }
}

(new SolutionsFlags())->solution(SolutionsFlags::A);