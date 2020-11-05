Summernote Plugin for CakePHP

INSTALLATION:

1. Copy plugin folder in your app/Plugin directory.

2. Load plugin in your app/Config/bootsrtap.php file:

CakePlugin::load('Summernote');

3. Put code below to default layout file (in HEAD section):

<!-- include libries(jQuery, bootstrap, fontawesome) -->
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css"> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<?php
    echo $this->element('Summernote.summernote', array(
        // CSS selector
        'selector' => '.wysiwyg',
        // Options
        'options' => "{
            // Options from http://hackerwins.github.io/summernote/features.html#api-summernote
            lang: 'pl-PL'
        }",
        // Language files
        'language' => array('pl-PL')
    ));
?>

4. Create textarea element with CSS selector's class in any of your ctp/tpl file. For example:

<textarea name="description" class="wysiwyg"></textarea>

or 

<?php echo $this->Form->input('description', array('class' => 'wysiwyg', 'placeholder' => __('WYSIWYG editor'), 'label' => __('WYSIWYG editor'))); ?>