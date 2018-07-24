<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class BaseRepository
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return string
     */
    abstract protected function modelClassName();

    /**
     * @return Model
     * @throws Exception
     */
    private function makeModel() {
        $model = $this->app->make($this->modelClassName());

        if (!$model instanceof Model)
            throw new Exception("Class {$this->modelClassName()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }
}
