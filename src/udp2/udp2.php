<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace udp2;

    use Exception;
    use TmpFile\TmpFile;
    use udp2\Abstracts\ColorScheme;
    use udp2\Abstracts\ColorThemes;
    use udp2\Abstracts\DefaultAvatarType;
    use udp2\Classes\HashDisplayPictureGenerator;
    use udp2\Classes\ImageProcessor;
    use udp2\Classes\InitialsAvatarGenerator;
    use udp2\Exceptions\AvatarGeneratorException;
    use udp2\Exceptions\AvatarNotFoundException;
    use udp2\Exceptions\ImageTooSmallException;
    use udp2\Exceptions\UnsupportedAvatarGeneratorException;
    use Zimage\Exceptions\CannotGetOriginalImageException;
    use Zimage\Exceptions\FileNotFoundException;
    use Zimage\Exceptions\InvalidZimageFileException;
    use Zimage\Exceptions\SizeNotSetException;
    use Zimage\Exceptions\UnsupportedImageTypeException;
    use Zimage\Objects\Size;
    use Zimage\Zimage;

    class udp2
    {
        /**
         * The directory
         *
         * @var string
         */
        private $storage_location;

        /**
         * udp constructor.
         */
        public function __construct()
        {
           $this->storage_location = DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'udp2';
        }

        /**
         * @return string
         */
        public function getStorageLocation(): string
        {
            return $this->storage_location;
        }

        /**
         * @param string $storage_location
         */
        public function setStorageLocation(string $storage_location): void
        {
            $this->storage_location = $storage_location;
        }

        /**
         * Returns the location of the avatar image
         *
         * @param string $id
         * @return string
         */
        public function getAvatarLocation(string $id): string
        {
            return $this->getStorageLocation() . DIRECTORY_SEPARATOR . hash('sha384', $id) . '.zimage';
        }

        /**
         * @param string $file
         * @param string $id
         * @param bool $check_size
         * @return bool
         * @throws CannotGetOriginalImageException
         * @throws FileNotFoundException
         * @throws ImageTooSmallException
         * @throws SizeNotSetException
         * @throws UnsupportedImageTypeException
         */
        public function applyAvatar(string $file, string $id, bool $check_size=false): bool
        {
            $zimage = Zimage::createFromImage($file, true);

            if($check_size)
            {
                if($zimage->getOriginalSize()->getWidth() < 640 || $zimage->getOriginalSize()->getHeight() < 640)
                {
                    throw new ImageTooSmallException();
                }
            }

            if($zimage->getOriginalSize()->getWidth() !== 640 && $zimage->getOriginalSize()->getHeight() !== 640)
                $zimage = ImageProcessor::resizeImageModern($zimage, new Size('640x640'));

            if(file_exists($this->getAvatarLocation($id)))
                unlink($this->getAvatarLocation($id));

            $zimage->setSizes([
                new Size('512x512'),
                new Size('360x360'),
                new Size('160x160'),
                new Size('64x64'),
            ]);

            $zimage->save($this->getAvatarLocation($id));
            return true;
        }

        /**
         * Generates a default avatar using various generators
         *
         * @param string $id
         * @param string|null $input
         * @param string $type
         * @return bool
         * @throws CannotGetOriginalImageException
         * @throws FileNotFoundException
         * @throws ImageTooSmallException
         * @throws SizeNotSetException
         * @throws UnsupportedAvatarGeneratorException
         * @throws UnsupportedImageTypeException
         * @throws AvatarGeneratorException
         */
        public function generateAvatar(string $id, string $input=null, string $type=DefaultAvatarType::HashBased, string $color_scheme=ColorScheme::Random, ?array $color_theme=ColorThemes::Random): bool
        {
            if($input == null)
                $input = $id;

            switch($type)
            {
                case DefaultAvatarType::HashBased:
                    $hash_based_generator = new HashDisplayPictureGenerator();
                    try
                    {
                        $image_resource = $hash_based_generator->getImageData($input, 640);
                    }
                    catch (Exception $e)
                    {
                        throw new AvatarGeneratorException('There was an unknown error while trying to generate the avatar', null, $e);
                    }

                    $tmp_file = new TmpFile($image_resource);
                    $this->applyAvatar($tmp_file->getFileName(), $id);
                    break;

                case DefaultAvatarType::InitialsBase:
                    $initials_based_generator = new InitialsAvatarGenerator();
                    $initials_based_generator->width(640);
                    $initials_based_generator->height(640);

                    if($color_theme == null)
                        $color_theme = ColorThemes::AllColors[array_rand(ColorThemes::AllColors)];

                    if(
                        $color_theme == ColorScheme::Random ||
                        $color_scheme !== ColorScheme::Dark ||
                        $color_scheme !== ColorScheme::Light
                    )
                    {
                        if(rand(0,1) == 1)
                        {
                            $color_scheme = ColorScheme::Light;
                        }
                        else
                        {
                            $color_scheme = ColorScheme::Dark;
                        }
                    }

                    switch($color_scheme)
                    {
                        case ColorScheme::Light:
                            $initials_based_generator->color($color_theme[0]);
                            $initials_based_generator->background($color_theme[1]);
                            break;

                        case ColorScheme::Dark:
                            $initials_based_generator->color($color_theme[1]);
                            $initials_based_generator->background($color_theme[0]);
                            break;
                    }

                    try
                    {
                        $image_resource = $initials_based_generator->name($input)->generate();
                    }
                    catch(Exception $e)
                    {
                        throw new AvatarGeneratorException('There was an unknown error while trying to generate the avatar', null, $e);
                    }

                    $tmp_file = new TmpFile(null, ".jpg");
                    $image_resource->save($tmp_file->getFileName(), 100);
                    $this->applyAvatar($tmp_file->getFileName(), $id);
                    break;

                default:
                    throw new UnsupportedAvatarGeneratorException('The generator "' . $type . '" is not supported');
            }

            return true;
        }

        /**
         * Determines if the avatar location exists or not
         *
         * @param string $id
         * @return bool
         */
        public function avatarExists(string $id): bool
        {
            return file_exists($this->getAvatarLocation($id));
        }

        /**
         * Returns the Zimage object of the avatar
         *
         * @param string $id
         * @return Zimage
         * @throws AvatarNotFoundException
         * @throws FileNotFoundException
         * @throws InvalidZimageFileException
         */
        public function getAvatar(string $id): Zimage
        {
            if($this->avatarExists($id) == false)
                throw new AvatarNotFoundException('The requested avatar "' . $id . '" does not exist');

            return Zimage::load($this->getAvatarLocation($id), true);
        }
    }