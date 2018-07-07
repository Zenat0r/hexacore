<?php

if ( ! function_exists('base_url'))
{
	function base_url($path='')
	{
        /*if (isset($_SERVER['SERVER_ADDR']))
        {
            if (strpos($_SERVER['SERVER_ADDR'], ':') !== FALSE)
            {
                $server_addr = '['.$_SERVER['SERVER_ADDR'].']';
            }
            else
            {
                $server_addr = $_SERVER['SERVER_ADDR'];
            }

            $base_url = 'http://'.$server_addr
                .substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
        }
        else
        {
            $base_url = 'http://localhost/';
        }*/
		return "https://chtis-gamers.fr/".$path;
	}
}

if ( ! function_exists('css_url'))
{
	function css_url($nom)
	{
		return base_url() . 'assets/css/' . $nom . '.css';
	}
}


if ( ! function_exists('js_url'))
{
	function js_url($nom)
	{
		return base_url() . 'assets/js/' . $nom . '.js';
	}
}

if ( ! function_exists('img_url'))
{
	function img_url($nom)
	{
		return base_url() . 'assets/img/' . $nom;
	}
}
if ( ! function_exists('vid_url'))
{
	function vid_url($nom)
	{
		return base_url() . 'assets/vid/' . $nom;
	}
}


if ( ! function_exists('font_url'))
{
	function font_url($nom)
	{
		return base_url() . 'assets/fonts/' . $nom;
	}
}

if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'auto', $code = NULL)
	{
		if ( ! preg_match('#^(\w+:)?//#i', $uri))
		{
			$uri = base_url($uri);
		}

		if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
		{
			$method = 'refresh';
		}
		elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
		{
			if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
			{
				$code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
					? 303
					: 307;
			}
			else
			{
				$code = 302;
			}
		}

		switch ($method)
		{
			case 'refresh':
				header('Refresh:0;url='.$uri);
				break;
			default:
				header('Location: '.$uri, TRUE, $code);
				break;
		}
		exit;
	}
}
