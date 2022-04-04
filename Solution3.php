<?php


class SolutionsFlags
{
    public const A = [1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2];


 //   public const A = [1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2, 1, 5, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2];

    /**
     * @var int
     */
    public $minDiffBetweenPicks;

    /**
     * @var int
     */
    public $maxDiffBetweenPicks = 0;

    public $maxFlagCount;
    /**
     * @param string[] $heights
     *
     */
    public function solution(array $heights): void
    {
        $this->maxFlagCount = round(sqrt(count($heights)),0,PHP_ROUND_HALF_DOWN);
//        $this->minDiffBetweenPicks = count($heights);
        $this->minDiffBetweenPicks =$this->maxFlagCount;

        $pics = $this->getPics($heights);
        $pics = $this->setLengths($pics);
//        print_r($pics);
//
//        var_dump($this->minDiffBetweenPicks);
//        var_dump($this->maxDiffBetweenPicks);
        $result = $this->findMaxFlagCount($pics);

        var_dump($result);
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

        for ($indexPoint = 1; $indexPoint <= $lastIndexPic; $indexPoint++) {
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

        if ($this->maxDiffBetweenPicks == $this->minDiffBetweenPicks && $this->maxDiffBetweenPicks <= count($pics)){
            return $this->maxDiffBetweenPicks;
        }elseif ($this->minDiffBetweenPicks == count($pics)){
            return $this->minDiffBetweenPicks;
        }elseif ($this->maxDiffBetweenPicks > count($pics)){
            $this->maxDiffBetweenPicks = count($pics);
        }


        $maxCountOfFlags = $this->minDiffBetweenPicks;


        for($flagsCountVariant = $this->minDiffBetweenPicks; $flagsCountVariant <= $this->maxDiffBetweenPicks; $flagsCountVariant++){

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
            }elseif ($prevIndex-$index > $this->maxDiffBetweenPicks) {
                $this->maxDiffBetweenPicks =$prevIndex-$index ;
            }

            $prevIndex = $index;
        }

        return $pics;
    }
}

(new SolutionsFlags())->solution(SolutionsFlags::A);