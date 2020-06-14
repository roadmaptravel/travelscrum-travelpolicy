<?php

class App {
    
    public static function showError ($get, $message = '') {
        
        if (isset ($get['state']) && $get['state'] == 'error') {
            
            $html = '<div class="alert alert-danger fade in m-b-15">
						<strong>Error!</strong>
						'. $message .'
						<span class="close" data-dismiss="alert">&times;</span>
					</div>';
					
            echo $html;
            
        }
        
    }
    
    public static function tinyMCE ($element, $mode = 'exact') {
        
        $path = baseHref . '/assets/plugins/tiny_mce/js/tinymce/tinymce.min.js';
        
        if ($mode == 'exact') {
            
            $selector = 'elements : "'. $element .'"';
            
        } else if ($mode == 'specific_textareas') {
            
            $selector = 'editor_selector : "'. $element .'"';
            
        }
        $html = <<<EOT
<script type="text/javascript" src="{$path}"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "{$mode}",
        {$selector},
        
        plugins : "advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste moxiemanager",
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        height : "400",
        width: "95%",
        accessibility_warnings : false,
        accessibility_focus : false,
        relative_urls : false,
        remove_script_host : false,
        image_advtab : true,
        bull: 1,
    });
</script>
EOT;

        return $html;
        
    }
    
    public static function currentUrl () {
        
          return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
          );
    }
    
    public static function showSuccess ($get, $message = '') {
        
        if (isset ($get['state']) && $get['state'] == 'success') {
            
            $html = '<div class="alert alert-success fade in m-b-15">
						<strong>Success!</strong>
						Actie succesvol geslaagd
						<span class="close" data-dismiss="alert">&times;</span>
					</div>';
					
            echo $html;
            
        }
        
    }
    
    public static function current ($page, $class = 'active', $classOnly = false)
    {
        if (!isset ($_GET['route']))
        {
            $current = 'index';
        }
        else
        {
            $current = $_GET['route'];
        }
        
        
        if ($current === $page)
        {
            
            
            if ($classOnly === true)
            {
                return $class;
            }
            else
            {
                return ' class="'. $class .'"';
            }
            
        }
    }
    
    public static function currentS ($page, $class = 'active', $classOnly = false)
    {
        if (!isset ($_GET['action']))
        {
            $current = 'index';
        }
        else
        {
            $current = $_GET['action'];
        }
        
        if ($current === $page)
        {
            
            if ($classOnly === true)
            {
                return $class;
            }
            else
            {
                return ' class="'. $class .'"';
            }
            
        }
    }
 
    public static function ean ($digits) {
        
        $digits =(string)$digits;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        return $digits . $check_digit;
        
    }
    
    public static function date ($date, $format = 'd-m-Y H:i:s', $lang = false) {
        
        if (!$date) {
            
            return '-';
            
        }
        
        if ($lang !== false) {
	        
			$fmt = new IntlDateFormatter(
			    $lang,
			     IntlDateFormatter::GREGORIAN,
				 IntlDateFormatter::FULL,
				 'Europe/Amsterdam',
				 IntlDateFormatter::GREGORIAN,
				 $format
			);
			return $fmt->format(strtotime ($date));

	        
        } else {
		        
	        $date = strtotime ($date);
	        
	        return date ($format, $date);
	        
		}
		
    }
    
}