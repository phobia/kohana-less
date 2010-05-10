KO3 LESS Module
===============

LESS Module is a port of Leaf Corcoran's [LESSPHP](http://leafo.net/lessphp) for Kohana 3
It adopts some of Alex Sancho's Kohana 2.3 Assets Module codes for CSS compression, credits goes to them
Thanks to [cheeaun](http://github.com/cheeaun) for helping out

To Use
-------
1. Put the less module folder in your Modules directory
2. Include less module in your application's bootstrap: 'less' => MODPATH.'less'
3. Copy the less config file from /modules/less/config/less.php to your application's config directory
4. From your less.php config file, put the path to where you want the CSS files compiled / compressed, the folder must be writable
5. You can set compression to TRUE on your less.php config file if you want your CSS files to be combined in to one file and compressed

Sample Code
------------
** /media/css/style.less **

		@bodyBkgColor: #EEE;

		body {
			background: @bodyBkgColor;

			h1 { font-size: 3em; }
		}

** APPPATH/classes/controller/sample.php **

		Controller_Home extends Controller_Template {

			public $template = 'template';
			public $stylesheets = array('/media/css/reset.less', '/media/css/style.less');

			public function action_index()
			{
				$this->template->stylesheets = Less::set($this->stylesheets);
			}
		}

** APPPATH/views/template.php **

		<html>
		<head>
			<title>LESS for Kohana</title>
			<?= $stylesheets ?>
		</head>
		<body>
			<h1>LESS for Kohana or Kohana for LESS?</h1>
		</body>
		</html>

Issues
-------
Please report it to the [issues tracker](http://github.com/mongeslani/LESS-for-KO3/issues).