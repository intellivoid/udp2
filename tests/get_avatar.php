<?php
    require('ppm');
    import('net.intellivoid.udp2');

    $udp = new \udp2\udp2();
    $avatar = ($_GET['id'] ?? 'xD');
    $name = ($_GET['name'] ?? $avatar);
    $avatar_type = \udp2\Abstracts\DefaultAvatarType::InitialsBase;

    if(isset($_GET['hb']))
        $avatar_type = \udp2\Abstracts\DefaultAvatarType::HashBased;

    if(isset($_GET['new']) && $_GET['new'] == '1')
        $udp->generateAvatar($avatar, $name, $avatar_type);

    try
    {
        $zimage = $udp->getAvatar($avatar);
    }
    catch (\udp2\Exceptions\AvatarNotFoundException $e)
    {
        $udp->generateAvatar($avatar, $name, $avatar_type);
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
