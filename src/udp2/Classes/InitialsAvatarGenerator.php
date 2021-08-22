<?php

    namespace udp2\Classes;


    use ImageLib\AbstractFont;
    use ImageLib\Image;
    use ImageLib\ImageManager;
    use SvgLib\Nodes\Shapes\SVGCircle;
    use SvgLib\Nodes\Shapes\SVGRect;
    use SvgLib\Nodes\Structures\SVGFont;
    use SvgLib\Nodes\Texts\SVGText;
    use SvgLib\SVG;
    use udp2\Classes\InitialsTranslator\En;
    use udp2\Classes\InitialsTranslator\ZhCN;
    use udp2\Interfaces\LanguageBase;
    use udp2\Utilities\Initials;
    use udp2\Utilities\LanguageScriptDetection;

    class InitialsAvatarGenerator
    {
        /**
         * @var ImageManager
         */
        protected ImageManager $image;

        /**
         * @var Initials
         */
        protected Initials $initials_generator;

        /**
         * @var string
         */
        protected string $driver = 'gd'; // imagick or gd

        /**
         * @var float
         */
        protected float $fontSize = 0.5;

        /**
         * @var string
         */
        protected string $name = 'John Doe';

        /**
         * @var int
         */
        protected int $width = 48;

        /**
         * @var int
         */
        protected int $height = 48;

        /**
         * @var string
         */
        protected string $bgColor = '#f0e9e9';

        /**
         * @var string
         */
        protected string $fontColor = '#8b5d5d';

        /**
         * @var bool
         */
        protected bool $rounded = false;

        /**
         * @var bool
         */
        protected bool $smooth = false;

        /**
         * @var bool
         */
        protected bool $autofont = false;

        /**
         * @var bool
         */
        protected bool $keepCase  = false;

        /**
         * @var bool
         */
        protected bool $allowSpecialCharacters = true;

        /**
         * @var string
         */
        protected string $fontFile = '/fonts/OpenSans-Regular.ttf';

        /**
         * @var string
         */
        protected string $fontName = 'OpenSans, sans-serif';

        /**
         * @var string
         */
        protected string $generated_initials = 'JD';

        /**
         * @var bool
         */
        protected bool $preferBold  = false;

        /**
         * Language eg.en zh-CN
         *
         * @var string
         */
        protected string $language = 'en';

        /**
         * Role translator
         *
         * @var LanguageBase
         */
        protected LanguageBase $translator;

        /**
         * Language related to translator
         *
         * @var array
         */
        protected array $translatorMap = [
            'en'    => En::class,
            'zh-CN' => ZhCN::class,
        ];

        public function __construct()
        {
            $this->setupImageManager();
            $this->initials_generator = new Initials();
        }

        /**
         * Create a ImageManager instance
         */
        protected function setupImageManager()
        {
            $this->image = new ImageManager([ 'driver' => $this->getDriver() ]);
        }

        /**
         * Set the name used for generating initials.
         *
         * @param string $nameOrInitials
         * @return $this
         */
        public function name($nameOrInitials)
        {
            $nameOrInitials = $this->translate($nameOrInitials);
            $this->name     = $nameOrInitials;
            $this->initials_generator->name($nameOrInitials);

            return $this;
        }

        /**
         * Transforms a unicode string to the proper format
         *
         * @param string $char the code to be converted (e.g., f007 would mean the "user" symbol)
         * @return $this
         */
        public function glyph($char)
        {
            $uChar = json_decode(sprintf('"\u%s"', $char), false);
            $this->name($uChar);

            return $this;
        }

        /**
         * Set the length of the generated initials.
         *
         * @param int $length
         * @return $this
         */
        public function length($length = 2)
        {
            $this->initials_generator->length($length);
            return $this;
        }

        /**
         * Set the avatar/image size in pixels.
         *
         * @param int $size
         * @return $this
         */
        public function size($size)
        {
            $this->width  = (int) $size;
            $this->height = (int) $size;

            return $this;
        }

        /**
         * Set the avatar/image height in pixels.
         *
         * @param int $height
         * @return $this
         */
        public function height($height)
        {
            $this->height = (int) $height;

            return $this;
        }

        /**
         * Set the avatar/image width in pixels.
         *
         * @param int $width
         * @return $this
         */
        public function width($width)
        {
            $this->width = (int) $width;

            return $this;
        }

        /**
         * Prefer bold fonts (if possible)
         *
         * @return $this
         */
        public function preferBold()
        {
            $this->preferBold = true;

            return $this;
        }

        /**
         * Prefer regular fonts (if possible)
         *
         * @return $this
         */
        public function preferRegular()
        {
            $this->preferBold = false;

            return $this;
        }

        /**
         * Set the background color.
         *
         * @param string $background
         * @return $this
         */
        public function background($background)
        {
            $this->bgColor = (string) $background;

            return $this;
        }

        /**
         * Set the font color.
         *
         * @param string $color
         * @return $this
         */
        public function color($color)
        {
            $this->fontColor = (string) $color;

            return $this;
        }

        /**
         * Set the font file by path or int (1-5).
         *
         * @param string|int $font
         * @return $this
         */
        public function font($font)
        {
            $this->fontFile = $font;

            return $this;
        }

        /**
         * Set the font name
         * Example: "Open Sans"
         *
         * @param string $name
         * @return $this
         */
        public function fontName($name)
        {
            $this->fontName = $name;

            return $this;
        }

        /**
         * Use imagick as the driver.
         *
         * @return $this
         */
        public function imagick()
        {
            $this->driver = 'imagick';
            $this->setupImageManager();

            return $this;
        }

        /**
         * Use GD as the driver.
         *
         * @return $this
         */
        public function gd()
        {
            $this->driver = 'gd';
            $this->setupImageManager();

            return $this;
        }

        /**
         * Set if should make a round image or not.
         *
         * @param bool $rounded
         * @return $this
         */
        public function rounded($rounded = true)
        {
            $this->rounded = (bool) $rounded;

            return $this;
        }

        /**
         * Set if should detect character script
         * and use a font that supports it.
         *
         * @param bool $autofont
         * @return $this
         */
        public function autoFont($autofont = true)
        {
            $this->autofont = (bool) $autofont;

            return $this;
        }

        /**
         * Set if should make a rounding smoother with a resizing hack.
         *
         * @param bool $smooth
         * @return $this
         */
        public function smooth($smooth = true)
        {
            $this->smooth = (bool) $smooth;

            return $this;
        }

        /**
         * Set if should skip uppercasing the name.
         *
         * @param bool $keepCase
         * @return $this
         */
        public function keepCase($keepCase = true)
        {
            $this->keepCase = (bool) $keepCase;

            return $this;
        }

        /**
         * Set if should allow (or remove) special characters
         *
         * @param bool $allowSpecialCharacters
         * @return $this
         */
        public function allowSpecialCharacters($allowSpecialCharacters = true)
        {
            $this->allowSpecialCharacters = (bool) $allowSpecialCharacters;

            return $this;
        }

        /**
         * Set the font size in percentage
         * (0.1 = 10%).
         *
         * @param float $size
         * @return $this
         */
        public function fontSize($size = 0.5)
        {
            $this->fontSize = number_format($size, 2);

            return $this;
        }

        /**
         * Generate the image.
         *
         * @param null|string $name
         * @return Image
         */
        public function generate($name = null)
        {
            if ($name !== null)
            {
                $this->name               = $name;
                $this->generated_initials = $this->initials_generator->keepCase($this->getKeepCase())
                    ->allowSpecialCharacters($this->getAllowSpecialCharacters())
                    ->generate($name);
            }

            return $this->makeAvatar($this->image);
        }

        /**
         * Generate the image.
         *
         * @param null|string $name
         * @return SVG
         */
        public function generateSvg($name = null)
        {
            if ($name !== null)
            {
                $this->name               = $name;
                $this->generated_initials = $this->initials_generator->keepCase($this->getKeepCase())
                    ->allowSpecialCharacters($this->getAllowSpecialCharacters())
                    ->generate($name);
            }

            return $this->makeSvgAvatar();
        }

        /**
         * Will return the generated initials.
         *
         * @return string
         */
        public function getInitials()
        {
            return $this->initials_generator->keepCase($this->getKeepCase())
                ->allowSpecialCharacters($this->getAllowSpecialCharacters())
                ->name($this->name)
                ->getInitials();
        }

        /**
         * Will return the background color parameter.
         *
         * @return string
         */
        public function getBackgroundColor()
        {
            return $this->bgColor;
        }

        /**
         * Will return the set driver.
         *
         * @return string
         */
        public function getDriver()
        {
            return $this->driver;
        }

        /**
         * Will return the font color parameter.
         *
         * @return string
         */
        public function getColor()
        {
            return $this->fontColor;
        }

        /**
         * Will return the font size parameter.
         *
         * @return float
         */
        public function getFontSize()
        {
            return $this->fontSize;
        }

        /**
         * Will return the font file parameter.
         *
         * @return string|int
         */
        public function getFontFile()
        {
            return $this->fontFile;
        }

        /**
         * Will return the font name parameter for SVGs.
         *
         * @return string
         */
        public function getFontName()
        {
            return $this->fontName;
        }

        /**
         * Will return the round parameter.
         *
         * @return bool
         */
        public function getRounded()
        {
            return $this->rounded;
        }

        /**
         * Will return the smooth parameter.
         *
         * @return bool
         */
        public function getSmooth()
        {
            return $this->smooth;
        }

        /**
         * @deprecated for getWidth and getHeight
         */
        public function getSize()
        {
            return $this->getWidth();
        }

        /**
         * Will return the width parameter.
         *
         * @return int
         */
        public function getWidth()
        {
            return $this->width;
        }

        /**
         * Will return the height parameter.
         *
         * @return int
         */
        public function getHeight()
        {
            return $this->height;
        }

        /**
         * Will return the keepCase parameter.
         *
         * @return boolean
         */
        public function getKeepCase()
        {
            return $this->keepCase;
        }

        /**
         * Will return the allowSpecialCharacters parameter.
         *
         * @return boolean
         */
        public function getAllowSpecialCharacters()
        {
            return $this->allowSpecialCharacters;
        }

        /**
         * Will return the autofont parameter.
         *
         * @return bool
         */
        public function getAutoFont()
        {
            return $this->autofont;
        }

        /**
         * Set language of name, pls use `language` before `name`, just like
         * ```php
         * $avatar->language('en')->name('Mr Green'); // Right
         * $avatar->name('Mr Green')->language('en'); // Wrong
         * ```
         *
         * @param string $language
         * @return $this
         */
        public function language($language)
        {
            $this->language = $language ?: 'en';

            return $this;
        }

        /**
         * Add new translators designed by user
         *
         * @param array $translatorMap
         *     ```php
         *     $translatorMap = [
         *     'fr' => 'foo\bar\Fr',
         *     'zh-TW' => 'foo\bar\ZhTW'
         *     ];
         *     ```
         * @return $this
         */
        public function addTranslators($translatorMap)
        {
            $this->translatorMap = array_merge($this->translatorMap, $translatorMap);

            return $this;
        }

        /**
         * @inheritdoc
         */
        protected function translate($nameOrInitials)
        {
            return $this->getTranslator()->translate($nameOrInitials);
        }

        /**
         * Instance the translator by language
         *
         * @return LanguageBase
         */
        protected function getTranslator()
        {
            if ($this->translator instanceof LanguageBase && $this->translator->getSourceLanguage() === $this->language) {
                return $this->translator;
            }

            $translatorClass = array_key_exists($this->language, $this->translatorMap) ? $this->translatorMap[ $this->language ] : 'LasseRafn\\InitialAvatarGenerator\\Translator\\En';

            return $this->translato = new $translatorClass();
        }

        /**
         * @param ImageManager $image
         * @return Image
         */
        protected function makeAvatar($image)
        {
            $width    = $this->getWidth();
            $height   = $this->getHeight();
            $bgColor  = $this->getBackgroundColor();
            $name     = $this->getInitials();
            $fontFile = $this->findFontFile();
            $color    = $this->getColor();
            $fontSize = $this->getFontSize();

            if ($this->getRounded() && $this->getSmooth())
            {
                $width *= 5;
                $height *= 5;
            }

            $avatar = $image->canvas($width, $height, ! $this->getRounded() ? $bgColor : null);

            if ($this->getRounded())
            {
                $avatar = $avatar->circle($width - 2, $width / 2, $height / 2, function ($draw) use ($bgColor)
                {
                    return $draw->background($bgColor);
                });
            }

            if ($this->getRounded() && $this->getSmooth())
            {
                $width /= 5;
                $height /= 5;
                $avatar->resize($width, $height);
            }

            return $avatar->text($name, $width / 2, $height / 2, function (AbstractFont $font) use ($width, $color, $fontFile, $fontSize)
            {
                $font->file($fontFile);
                $font->size($width * $fontSize);
                $font->color($color);
                $font->align('center');
                $font->valign('center');
            });
        }

        /**
         * @return SVG
         */
        protected function makeSvgAvatar()
        {
            // Original document
            $image    = new SVG($this->getWidth(), $this->getHeight());
            $document = $image->getDocument();

            // Background
            if ($this->getRounded())
            {
                // Circle
                $background = new SVGCircle($this->getWidth() / 2, $this->getHeight() / 2, $this->getWidth() / 2);
            }
            else
            {
                // Rectangle
                $background = new SVGRect(0, 0, $this->getWidth(), $this->getHeight());
            }

            $background->setStyle('fill', $this->getBackgroundColor());
            $document->addChild($background);

            // Text
            $text = new SVGText($this->getInitials(), '50%', '50%');
            $text->setFont(new SVGFont($this->getFontName(), $this->findFontFile()));
            $text->setStyle('line-height', 1);
            $text->setAttribute('dy', '.1em');
            $text->setAttribute('fill', $this->getColor());
            $text->setAttribute('font-size', $this->getFontSize() * $this->getWidth());
            $text->setAttribute('text-anchor', 'middle');
            $text->setAttribute('dominant-baseline', 'middle');

            if ($this->preferBold)
                $text->setStyle('font-weight', 600);

            $document->addChild($text);

            return $image;
        }

        /** @noinspection RegExpRedundantEscape */
        protected function findFontFile()
        {
            $fontFile = $this->getFontFile();

            if ($this->getAutoFont())
                $fontFile = $this->getFontByScript();

            if (is_int($fontFile) && \in_array($fontFile, [ 1, 2, 3, 4, 5 ], false))
                return $fontFile;

            $weightsToTry = [ 'Regular' ];

            if ($this->preferBold)
                $weightsToTry = [ 'Bold', 'Semibold', 'Regular' ];

            $originalFile = $fontFile;

            foreach ($weightsToTry as $weight)
            {
                $fontFile = preg_replace('/(\-(Bold|Semibold|Regular))/', "-{$weight}", $originalFile);

                if (file_exists($fontFile))
                    return $fontFile;

                if (file_exists(__DIR__ . $fontFile))
                    return __DIR__ . $fontFile;

                if (file_exists(__DIR__ . '/' . $fontFile))
                    return __DIR__ . '/' . $fontFile;
            }

            return 1;
        }

        protected function getFontByScript()
        {
            $FontsDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'Fonts' . DIRECTORY_SEPARATOR;
            // Arabic
            if (LanguageScriptDetection::isArabic($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Arabic-Regular.ttf';

            // Armenian
            if (LanguageScriptDetection::isArmenian($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Armenian-Regular.ttf';

            // Bengali
            if (LanguageScriptDetection::isBengali($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Bengali-Regular.ttf';

            // Georgian
            if (LanguageScriptDetection::isGeorgian($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Georgian-Regular.ttf';

            // Hebrew
            if (LanguageScriptDetection::isHebrew($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Hebrew-Regular.ttf';

            // Mongolian
            if (LanguageScriptDetection::isMongolian($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Mongolian-Regular.ttf';

            // Thai
            if (LanguageScriptDetection::isThai($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Thai-Regular.ttf';

            // Tibetan
            if (LanguageScriptDetection::isTibetan($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-Tibetan-Regular.ttf';

            // Chinese & Japanese
            if (LanguageScriptDetection::isJapanese($this->getInitials()) || LanguageScriptDetection::isChinese($this->getInitials()))
                return $FontsDirectory . 'Script' . DIRECTORY_SEPARATOR . 'Noto-CJKJP-Regular.otf';

            return $this->getFontFile();
        }
    }
