<?php
    require('ppm');
    import('net.intellivoid.udp2');

    $udp = new \udp2\udp2();
    $avatar = ($_GET['id'] ?? '1234567890');

    try
    {
        $zimage = $udp->getAvatar($avatar);
    }
    catch (\udp2\Exceptions\AvatarNotFoundException $e)
    {
        $udp->generateAvatar($avatar);
        $zimage = $udp->getAvatar($avatar);
    }
?>

<html>
    <head>
        <title>Avatar Formats</title>
    </head>
    <body>
        <?PHP
            foreach($zimage->getSizes() as $size)
            {
                ?>
                <h2><?PHP print((string)$size); ?></h2>
                <img src="data:image/jpeg;charset=utf-8;base64,<?PHP print(base64_encode($zimage->getImageBySize($size)->getData())); ?>">
                <hr/>
                <?PHP
            }
        ?>
    </body>
</html>
