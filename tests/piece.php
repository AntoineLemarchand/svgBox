<?php $len = "100"; $wigroom=($len-30)/$len; ?>
<html>
<body>
<p><?php echo $wigroom*100 ?> %</p>
<svg width="100%" height=100%>
  <path d="M 100,0
        l <?php echo $len ?>,0 l 0,<?php echo (($len*$wigroom)*.3) ?>
        q 5,0 5,5 l 0,5 q 0,5 -5,5
        l 0,<?php echo (($len*$wigroom)*.4) ?>
        q 5,0 5,5 l 0,5 q 0,5 -5,5
        l 0,<?php echo (($len*$wigroom)*.3) ?> l <?php echo -(($len*$wigroom)*.3) ?>,0
        q 0,5 -5,5 l -5,0 q -5,0 -5,-5
        l <?php echo -($len*$wigroom*.4) ?>,0
        q 0,5 -5,5 l -5,0 q -5,0 -5,-5
        l <?php echo -(($len*$wigroom)*.3) ?>,0 l 0,<?php echo -(($len*$wigroom)*.3) ?>
        q -5,0 -5,-5 l 0,-5 q 0,-5 5,-5
        l 0,<?php echo -(($len*$wigroom)*.4) ?>
        q -5,0 -5,-5 l 0,-5 q 0,-5 5,-5
        l 0,<?php echo -(($len*$wigroom)*.3) ?>
        " stroke="black" stroke-width="1" fill="none" />
  <path d="M 210,0
        l <?php echo $len ?>,0 l 0,<?php echo $len ?>
        l <?php echo -(($len*$wigroom)*.3) ?>,0
        q 0,5 -5,5 l -5,0 q -5,0 -5,-5 
        l <?php echo -($len*$wigroom*.4) ?>,0 
        q 0,5 -5,5 l -5,0 q -5,0 -5,-5
        l <?php echo -(($len*$wigroom)*.3) ?>,0 l 0,<?php echo -$len ?>
        m 5,<?php echo (($len*$wigroom)*.3) ?>
        l 5,0 l 0,15 l -5,0 l 0,-15 m 0,<?php echo (($len*$wigroom)*.4+15)?> l 5,0 l 0,15 l -5,0 l 0,-15
        m <?php echo ($len-15) ?>,0
        l 5,0 l 0,15 l -5,0 l 0,-15 m 0,<?php echo -(($len*$wigroom)*.4+15)?> l 5,0 l 0,15 l -5,0 l 0,-15
        " stroke="black" stroke-width="1" fill="none" />
  <path d="M 320, 0
        l <?php echo $len ?>,0 l 0,<?php echo $len ?> l <?php echo -$len ?>,0 l 0,<?php echo -$len ?>
        m 5,<?php echo (($len*$wigroom)*.3) ?>
        l 5,0 l 0,15 l -5,0 l 0,-15 m 0,<?php echo (($len*$wigroom)*.4+15)?> l 5,0 l 0,15 l -5,0 l 0,-15
        m <?php echo ($len-15) ?>,0
        l 5,0 l 0,15 l -5,0 l 0,-15 m 0,<?php echo -(($len*$wigroom)*.4+15)?> l 5,0 l 0,15 l -5,0 l 0,-15
        m <?php echo (-($len-10)+($len*$wigroom)*.3).",".(-(($len*$wigroom)*.3)+5) ?>
        l 15,0 l 0,5 l -15,0 l 0,-5 m <?php echo (($len*$wigroom)*.4+15) ?>,0 l 15,0 l 0,5 l -15,0 l 0,-5
        m <?php echo "0,".($len-15) ?>
        l 15,0 l 0,5 l -15,0 l 0,-5 m <?php echo -(($len*$wigroom)*.4+15) ?>,0 l 15,0 l 0,5 l -15,0 l 0,-5
        
        " stroke="black" stroke-width="1" fill="none" />
</svg>
</body>
</html>
