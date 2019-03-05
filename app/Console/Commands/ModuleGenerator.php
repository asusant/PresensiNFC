<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class ModuleGenerator extends Command
{
	/**
	 * The filesystem instance.
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:module {name}';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Crate modules for rapid fuckin development yah';
	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'module';
	/**
	 * Create a new controller creator command instance.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @return void'/
	 */
	public function __construct(Filesystem $files)
	{
			parent::__construct();
			$this->files = $files;
	}
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
			$this->fireController();
			// $this->fireModel();
			// $this->fireView();
			// $this->fireRoute();
	}

	//----------------------------------------------------CONTROLLER-------------------------------------------//
	/**
	 * Execute the console command.
	 *
	 * @return bool|null
	 */
	public function fireController()
	{
			// Ambil nama-nama file
			$name = $this->qualifyClass($this->getNameInput());
			$nameController = $name.'Controller';
			$nameModel = str_replace('Controllers', 'Models', $name);
			$nameView = str_replace($this->getNameInput().'.', strtolower($this->getNameInput()), str_replace('Controllers', 'Views', $name).'.');
			$nameRoute = str_replace('\\Controllers\\'.$this->getNameInput(), '\\routes', $name);
			// $nameView = str_replace($this->getNameInput().'.', strtolower($this->getNameInput()).'.', str_replace('Controllers', 'Views', $name).'.blade.php');


			//Ambil path
			$pathController = $this->getPath($nameController).'.php';
			$pathModel = $this->getPath($nameModel).'.php';
			$pathView = $this->getPath($nameView).'.blade.php';
			$pathRoute = $this->getPath($nameRoute).'.php';


			if ($this->alreadyExists($this->getNameInput())) {
					$this->error($this->type.' already exists!');
					return false;
			}


			$this->makeDirectory($pathController);
			$this->makeDirectory($pathModel);
			$this->makeDirectory($pathView);
			$this->makeDirectory($pathRoute);


			$this->files->put($pathController, $this->buildClassController($nameController));
			$this->files->put($pathModel, $this->buildClassModel($nameModel));
			$this->files->put($pathView, $this->buildClassView($nameView));
			$this->files->put($pathRoute, $this->buildClassRoute($nameRoute));


			$this->info( 'Hellyeah! '.$this->getNameInput().' '.$this->type.' was created.');
	}

	protected function qualifyClass($name)
	{
			$rootNamespace = $this->rootNamespace();
			if (Str::startsWith($name, $rootNamespace)) {
					return $name;
			}
			$name = str_replace('/', '\\', $name);
			return $this->qualifyClass(
					$this->getDefaultNamespace(trim($rootNamespace, '\\'), $name).'\\'.$name
			);
	}

	protected function getNameInput()
	{
			return trim($this->argument('name'));
	}

	protected function rootNamespace()
	{
			return $this->laravel->getNamespace();
	}

	protected function getPath($name)
	{
			$name = str_replace_first($this->rootNamespace(), '', $name);
			return $this->laravel['path'].'/'.str_replace('\\', '/', $name);
	}

	protected function alreadyExists($rawName)
	{
			return $this->files->exists($this->getPath($this->qualifyClass($rawName)));
	}

	protected function makeDirectory($path)
	{
			if (! $this->files->isDirectory(dirname($path))) {
					$this->files->makeDirectory(dirname($path), 0777, true, true);
			}
			return $path;
	}

	protected function buildClassController($name)
	{
			$stub = $this->files->get(__DIR__.'/stubs/controller.plain.stub');
			$class = str_replace($this->getNamespace($name).'\\', '', $name);
			$module = str_replace('Controller', '', $class);

			$stub = str_replace('DummyNamespace', $this->getNamespace($name), $stub);
			$stub = str_replace('DummyRootNamespace', $this->rootNamespace(), $stub);
			$stub = str_replace('DummyClass', $class, $stub);
			$stub = str_replace('selug', strtolower($module), $stub);
			$stub = str_replace('Kelas', $module, $stub);

			return $stub;
	}

	protected function buildClassModel($name)
	{
			$stub = $this->files->get(__DIR__.'/stubs/model.plain.stub');
			$class = str_replace($this->getNamespace($name).'\\', '', $name);

			$stub = str_replace('DummyNamespace', $this->getNamespace($name), $stub);
			$stub = str_replace('DummyRootNamespace', $this->rootNamespace(), $stub);
			$stub = str_replace('DummyClass', $class, $stub);
			$stub = str_replace('NamaModel', strtolower($class), $stub);

			return $stub;
	}

	protected function buildClassView($name)
	{
			$stub = $this->files->get(__DIR__.'/stubs/blade.plain.stub');
			$class = str_replace($this->getNamespace($name).'\\', '', $name);

			$stub = str_replace('DummyNamespace', $this->getNamespace($name), $stub);
			$stub = str_replace('DummyRootNamespace', $this->rootNamespace(), $stub);
			$stub = str_replace('DummyClass', $class, $stub);
			$stub = str_replace('NamaModel', strtolower($class), $stub);

			return $stub;
	}

	protected function buildClassRoute($name)
	{
			$stub = $this->files->get(__DIR__.'/stubs/route.plain.stub');
			return $stub;
	}

	protected function getNamespace($name)
	{
			return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
	}

	protected function getDefaultNamespace($rootNamespace, $name)
	{
		return $rootNamespace . '\Modules\\'.$name.'\\Controllers';
	}
}
