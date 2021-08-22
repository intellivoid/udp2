<?php

    namespace udp2\Classes;

    use udp2\Exceptions\FileUploadException;

    class Security
    {
        /**
         * Checks the upload to see if it's valid
         *
         * @return bool
         * @throws FileUploadException
         */
        public static function verify_upload(): bool
        {
            if (!isset($_FILES['user_av_file']['error']) || is_array($_FILES['user_av_file']['error']))
            {
                throw new FileUploadException('Failed to process File Upload');
            }

            switch ($_FILES['user_av_file']['error'])
            {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new FileUploadException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileUploadException('Exceeded File Size limit.');
                default:
                    throw new FileUploadException('Unknown file upload error');
            }

            if ($_FILES['user_av_file']['size'] > 3145728)
            {
                throw new FileUploadException('Exceeded File Size limit.');
            }

            return true;
        }
    }