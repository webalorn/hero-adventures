<?php
    
    function integrerEditorScript()
    {
        ?>
        <script type="text/javascript" src="/templates/editor/ckeditor.js"></script>
        <script type="text/javascript" src="/templates/editor/adOptionsCkeditor.js"></script>
        <?php
    }
    
    function Editor($id = null, $name = null, $contenu = "")
    {
        if ($id == null)
            $id = md5(rand());
        if ($name == null)
            $name = md5(rand());
        ?>
            <textarea id="<?php echo $id; ?>" name="<?php echo $name; ?>"><?php echo $contenu; ?></textarea>
            <script>
                CKEDITOR.replace(<?php echo $id; ?>);
            </script>
        <?php
    }
    
?>
