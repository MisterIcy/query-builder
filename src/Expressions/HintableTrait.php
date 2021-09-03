<?php

namespace MisterIcy\QueryBuilder\Expressions;

trait HintableTrait
{
    private bool $straightJoin = false;
    private bool $sqlNoCache = false;
    private bool $sqlCache = false;

    /**
     * @return bool
     */
    public function isStraightJoin(): bool
    {
        return $this->straightJoin;
    }

    /**
     * @param bool $straightJoin
     */
    public function setStraightJoin(bool $straightJoin): void
    {
        $this->straightJoin = $straightJoin;
    }

    /**
     * @return bool
     */
    public function isSqlNoCache(): bool
    {
        return $this->sqlNoCache;
    }

    /**
     * @param bool $sqlNoCache
     */
    public function setSqlNoCache(bool $sqlNoCache): void
    {
        $this->sqlNoCache = $sqlNoCache;
        $this->sqlCache = !$this->sqlNoCache;
    }

    /**
     * @return bool
     */
    public function isSqlCache(): bool
    {
        return $this->sqlCache;
    }

    /**
     * @param bool $sqlCache
     */
    public function setSqlCache(bool $sqlCache): void
    {
        $this->sqlCache = $sqlCache;
        $this->sqlNoCache = !$this->sqlCache;
    }
}