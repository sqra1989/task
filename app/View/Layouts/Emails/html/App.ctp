<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <title><?php echo $this->fetch('title'); ?></title>

        <style type="text/css">

            body {margin: 0; padding: 0; min-width: 100%!important; font-size: 13px;}

            .content {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;

                /*border: 3px solid #555555;*/
            }  

            table.bordered {
                border-bottom: 1px solid black;
            }

            table.blue {
                background-color: #EFF2F5;
                border-bottom: 2px solid #C1C1C1;
            }

            table {
                padding: 10px 15px;
                word-break: break-word;
            }

            table td {
                font-size: 13px;
            }


        </style>

    </head>
    <body yahoo bgcolor="#ffffff" style="font-family: 'Verdana', Courier; font-size: 13px;">
        <!-- <body yahoo bgcolor="#ffffff" style="font-family: 'Courier New', Courier; font-size: 14px;"> -->
        <div class="content app-content">
           
            <?php echo $this->fetch('content'); ?>
        </div>
    </body>
</html>