<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/24/15
 * Time: 1:36 PM
 */

$base_url = env('APP_URL', 'http://localhost') . '/' . env('CK_FINDER_FOLDER', 'files');
$base_dir = public_path(env('CK_FINDER_FOLDER', 'files'));

return [
    'base_dir'       => $base_dir,
    'access_control' => [
        'role'         => '*',
        'resourceType' => '*',
        'folder'       => '/',
        'folderView'   => true,
        'folderCreate' => true,
        'folderRename' => true,
        'folderDelete' => true,
        'fileView'     => true,
        'fileUpload'   => true,
        'fileRename'   => true,
        'fileDelete'   => true
    ],
    'thumbnails'     => [
        'url'          => $base_url . '/_thumbs',
        'directory'    => $base_dir . '/_thumbs',
        'enabled'      => true,
        'directAccess' => false,
        'maxWidth'     => 100,
        'maxHeight'    => 100,
        'bmpSupported' => false,
        'quality'      => 80
    ],
    'images'         => [
        'maxWidth'  => 1600,
        'maxHeight' => 1200,
        'quality'   => 80
    ],
    'resource_type'  => [
        [
            'name'              => 'Files',
            'url'               => $base_url . '/files',
            'directory'         => $base_dir . '/files',
            'maxSize'           => 0,
            'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
            'deniedExtensions'  => ''
        ],
        [
            'name'              => 'Images',
            'url'               => $base_url . '/images',
            'directory'         => $base_dir . '/images',
            'maxSize'           => 0,
            'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
            'deniedExtensions'  => ''
        ],
        [
            'name'              => 'Flash',
            'url'               => $base_url . '/flash',
            'directory'         => $base_dir . '/flash',
            'maxSize'           => 0,
            'allowedExtensions' => 'swf,flv',
            'deniedExtensions'  => ''
        ]
    ],
];