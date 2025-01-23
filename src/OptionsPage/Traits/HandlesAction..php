<?php

namespace Aikon\RoleManager\OptionsPage\Traits;

trait HandlesAction
{
    /**
     * The middleware
     *
     * @var callable[]
     */
    private array $middleware = [];

    /**
     * Add post action
     *
     * @param string $action_key The keý in request to check
     * @param string $action_value The value that the key should have
     * @param callable $callback The callback to run, receives the request as argument
     * @return void
     */
    public function post_action(string $action_key, string $action_value, callable $callback): void
    {
        $action = $_POST[$action_key] ?? null;

        if (
            $_SERVER['REQUEST_METHOD'] !== 'POST' ||
            $action !== $action_value
        ) {
            return;
        }

        if (!is_callable($callback)) {
            throw new \Exception('Post action callback is not callable');
        }

        $this->run_middleware();

        $callback($_REQUEST);
    }

    /**
     * Add get action
     *
     * @param string $action_key The keý in request to check
     * @param string $action_value The value that the key should have
     * @param callable $callback The callback to run, receives the request as argument
     * @return void
     */
    public function get_action(string $action_key, string $action_value, callable $callback): void
    {
        $action = $_GET[$action_key] ?? null;

        if (
            $_SERVER['REQUEST_METHOD'] !== 'GET' ||
            $action !== $action_value
        ) {
            return;
        }

        if (!is_callable($callback)) {
            throw new \Exception('Get action callback is not callable');
        }

        $this->run_middleware();

        $callback($_REQUEST);
    }

    /**
     * Add middleware
     *
     * @param callable $callback The callback to run, receives the request as argument
     * @return void
     */
    public function middleware(callable $callback): void
    {
        $this->middleware[] = $callback;
    }

    /**
     * Run middleware
     *
     * @return void
     */
    private function run_middleware(): void
    {
        foreach ($this->middleware as $middleware) {
            $middleware($_REQUEST);
        }
    }

}
