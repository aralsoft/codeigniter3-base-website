<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ($this->subDir && is_file(VIEWPATH.$this->subDir."/elements/header.php")) :
    include($this->subDir."/elements/header.php");
else :
    include("elements/header.php");
endif;

?>
<div class="container">

    <div class="row">
        <div class="col-md-12">

        <?php
        include("elements/page_title.php");
        include("elements/bread_crumb.php");
        include("elements/nav_tabs.php");
        include("elements/page_lead.php");

        $this->messages->render(); 
        ?>

        </div>
    </div>

<?php
    if ($viewPage) :
        include($viewPage);
    endif;
?>

</div>

<?php
if ($this->subDir && is_file(VIEWPATH.$this->subDir."/elements/footer.php")) :
    include($this->subDir."/elements/footer.php");
else :
    include("elements/footer.php");
endif;