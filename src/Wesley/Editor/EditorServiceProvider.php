<?php
namespace Wesley\Editor;
use Illuminate\Support\ServiceProvider;
class EditorServiceProvider extends ServiceProvider {

	public function boot()
	{
		$this->package('wesley-qiu/Editor');
		include __DIR__ . '/../../routes.php';
	}
	public function register()
	{
		/*$this->app->bindShared('Editor', function($app){
			$editor = new Editor();
			$config = $app['config']['editor'];
			foreach($config as $k=>$v){
				if( is_array($v) ){
					$editor->$k = array_merge($editor->$k, $v);
				}else{
					$editor->$k = $v;
				}
			}
			return $editor;
		});*/
		$this->app['command.wesley.publish'] = $this->app->share(function($app)
		{
			//Make sure the asset publisher is registered.
			$app->register('Illuminate\Foundation\Providers\PublisherServiceProvider');
			return new Console\PublishCommand($app['asset.publisher']);
		});
		$this->commands('command.wesley.publish');
	}	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.wesley.publish',);
	}
}