<?php

namespace Hexacore\Core\Storage\Session;

interface SessionInterface
{
    /**
     * Start the session
     *
     * @return void
     */
    public function start(): void;

    /**
     * End the session
     *
     * @return void
     */
    public function destroy(): void;
}
