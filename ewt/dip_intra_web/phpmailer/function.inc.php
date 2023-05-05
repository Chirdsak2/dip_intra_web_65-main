<?php
/*
* @version : 1.0
* @update : 2011-04-27
* @authur : อีมีเดีย
*/
set_time_limit(0);

if (!defined('IN_SITE')) die('Direct Access to this location is not allowed.');

function getUserProfileName( $user_id=0 ) {
global $ObjDB;
	$query = 'SELECT name FROM '.T_USER.' WHERE (`user_id`='.(int)$user_id.') LIMIT 1';
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query user information', '', __LINE__, __FILE__, $query);}
	$data = $ObjDB->sql_fetchrow($result);
	return $data['name'];
}

function Editor($name, $width, $height, $toolbar='', $content='') {
	
        /*$toolbarset = $toolbar;
        if($toolbarset == ''){
            $toolbarset = 'normal';
        }*/
        $toolbarset = 'normal';
        return editor::health_editor($name, $width, $height, $toolbarset, $content, $required);
        
	if((int)$height<=30){
			$height = 100;
	}
	if((int)$width<= 200){
			$width = 300;
	}
	$temp = Array();
	$temp['name'] = $name;
	$temp['style'][] = 'width:'.(int)$width.'px;';
	$temp['style'][] = 'height:'.(int)$height.'px;';
	$temp['text'] = $content;//$temp
	$temp['toolbar'] = 'lion_normal_basic_text';//$toolbar;
	return editor_new_2013($temp);
	
	require_once(BASEDIR_ADMIN.'/js/spaw2/spaw.inc.php');

	$sw = new SpawEditor( $name, $content );
	$sw->setDimensions( $width, $height );
	$sw->setConfigValue('default_toolbarset', $toolbar);

	return $sw->getHtml();
}

/*
* Generate Paging
*/
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true) {

	$total_pages = ceil($num_items/$per_page);
	if ( $total_pages == 1 ) return '';
	$on_page = floor($start_item / $per_page) + 1;
	$page_string = '';
	if ( $total_pages > 10 ) {
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++) {
			$page_string .= ( $i == $on_page ) ? '<span style="text-decoration: underline;"><b>' . $i . '</b></span>' : '<a href="' . ($base_url . '&amp;start=' . ( ( $i - 1 ) * $per_page ) ) . '" class="nav">' . $i . '</a>';
			if ( $i <  $init_page_max ) { $page_string .= ", "; }
		}

		if ( $total_pages > 3 ) {
			if ( $on_page > 1  && $on_page < $total_pages ) {
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++) {
					$page_string .= ($i == $on_page) ? '<span style="text-decoration: underline;"><b>' . $i . '</b></span>' : '<a href="' . ($base_url . '&amp;start=' . ( ( $i - 1 ) * $per_page ) ) . '" class="nav">' . $i . '</a>';
					if ( $i <  $init_page_max + 1 ) { $page_string .= ', '; }
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
			} else {
				$page_string .= ' ... ';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++) {
				$page_string .= ( $i == $on_page ) ? '<span style="text-decoration: underline;"><b>' . $i . '</b></span>'  : '<a href="' . ($base_url . '&amp;start=' . ( ( $i - 1 ) * $per_page ) ) . '" class="nav">' . $i . '</a>';
				if( $i <  $total_pages ) { $page_string .= ", "; }
			}
		}
		$page_list = ' | Goto Page :  '.'<select id="page_jump" name="page_jump" data-url="'.$base_url.'">';
		for( $i=1; $i<=$total_pages; $i++) {
			$page_list.= '<option value="' . ( ( $i - 1 ) * $per_page ) . '"'. ( $i == $on_page ? ' selected="selected"' : '').'>' . $i . '</option>';
		}
		$page_list.= '</select>';
	} else {
		for($i = 1; $i < $total_pages + 1; $i++) {
			$page_string .= ( $i == $on_page ) ? '<span style="text-decoration: underline;"><b>' . $i . '</b></span>' : '<a href="' . ($base_url . '&amp;start=' . ( ( $i - 1 ) * $per_page ) ) . '" class="nav">' . $i . '</a>';
			if ( $i <  $total_pages ) { $page_string .= ', '; }
		}
	}

	if ( $add_prevnext_text ) {
		if ( $on_page > 1 ) {
			$page_string = ' <a href="' . ($base_url . '&amp;start=' . ( ( $on_page - 2 ) * $per_page ) ) . '" class="nav">&lt;&lt; Previous</a>&nbsp;&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages ) {
			$page_string .= '&nbsp;&nbsp;<a href="' . ($base_url . '&amp;start=' . ( $on_page * $per_page ) ) . '" class="nav">Next &gt;&gt;</a>';
		}

	}
	
	return $page_string. $page_list;
	
}

function displayDimension($type='', $width=0, $height=0) 
{
    global $clsSession;
	$config = $clsSession->get_config('_ALL_');

	switch($type) 
        {
		case 'Default_Image': $width = 462; $height = 387; break;
		case 'Product_Category_Icon': $width = 87; $height = 64; break;
		case 'Products_Thumb': 
                    $width = 160;//$config['image_product_sku_size1_width']; 
                    $height = $config['image_product_sku_size1_height']; 
                break;
		case 'Products_Image': $width = $config['image_product_sku_size2_width']; $height = $config['image_product_sku_size2_height']; break;
		case 'Products_Hot': $width = $config['image_product_sku_size3_width']; $height = $config['image_product_sku_size3_height']; break;
		case 'Promotion_Thumb': $width = $config['image_product_sku_size1_width']; $height = $config['image_product_sku_size1_height']; break;
		case 'Promotion_Image': $width = $config['image_product_sku_size2_width']; $height = $config['image_product_sku_size2_height']; break;
		case 'Promotion_Hot': $width = $config['image_product_sku_size3_width']; $height = $config['image_product_sku_size3_height']; break;
		case 'News_Ecom_Thumb': $width = $config['image_news_ecom_thumb_width']; $height = $config['image_news_ecom_thumb_height']; break;
		case 'News_Ecom_Image': $width = $config['image_news_ecom_image_width']; $height = $config['image_news_ecom_image_height']; break;
		case 'Banner_Footer_Image': $width = $config['image_banner_footer_image_width']; $height = $config['image_banner_footer_image_height']; break;
		case 'News_Thumb': $width = 87; $height = 64; break;
		case 'News_Image': $width = 270; $height = 180; break;
		case 'News_Big': $width = 700; $height = 470; break;
		case 'Banner_Logo': $width = 203; $height = 68; break;
		case 'Sponsors_Logo': $width = 200; $height = 100; break;
		case 'Board_Image': $width = 126; $height = 160; break;
		case 'Knowledge_Thumb': $width = 77; $height = 59; break;
		case 'Intro_Image': $width = 700; $height = 450; break;
		case 'Banner_Head_Logo': $width = 950; $height = 198; break;
                case 'popup': $width = 750; $height = 450; break;
                case 'invite': $width = 225; $height = 200; break;
                case 'sku_image': $width = 350; $height = 350; break;
	}

	return sprintf('%dx%d', $width, $height);
	//return sprintf('Dimension: <u>%dx%d</u>', $width, $height);
}

/*
* Get Update Setting
*/
function UploadOptions($Group='') {
global $clsSession;

	$config = $clsSession->get_config('_ALL_');
	$options = array();
	$options['Crop_Thumb'] = false;
	$options['Fit_Image'] = true;

	$GroupContent = array(
		'Image' => array('Products_Thumb', 'Products_Hot', 'Products_Image', 'Product_Sku_Thumb', 'Product_Sku_Hot', 'Product_Sku_Image', 'Promotion_Thumb',  'Promotion_Image', 'News_Ecom_Thumb', 'News_Ecom_Image', 'Banner_Footer_Image', 'Product_Sku_scr0', 'Product_Sku_scr1', 'Product_Sku_scr2', 'Product_Sku_scr3', 'Product_Sku_scr4','image_image','Image_sku_thumbnail','Image_Hot','Image_src1','Image_src2','Image_src3','Image_src4'),
		'Gallery' => array('News_Gallery', 'News_Activity_Gallery' , 'News_Events_Gallery', 'Knowledge_Activity_Gallery', 'Section_Activity_Gallery', 'News_Activity_EN_Gallery'),
		'Attach' => array('Download','Form','News_Message','Links','Download_EN','Links_EN','Jobs')
	);

	$GroupPrefix = array( 'Menu_Image' );
	$options['prefix'] = ( in_array($Group, $GroupPrefix) ? false : true );

	if ( in_array($Group, $GroupContent['Image']) ) {
		//$options['FieldName'] = 'Image';
		if (in_array($Group, array('Products_Thumb', 'Product_Sku_Thumb', 'Promotion_Thumb'))) {
			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image1';
			$options['Image_Width'] = $config['image_product_sku_size1_width'];
			$options['Image_Height'] = $config['image_product_sku_size1_height'];

		}else if (in_array($Group, array('Products_Image', 'Product_Sku_Image', 'Promotion_Image'))) {
			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image2';
			$options['Image_Width'] = $config['image_product_sku_size2_width'];
			$options['Image_Height'] = $config['image_product_sku_size2_height'];

		}else if (in_array($Group, array('Products_Hot', 'Product_Sku_Hot', 'Promotion_Hot'))) {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image_Hot';
			$options['Image_Width'] = $config['image_product_sku_size3_width'];
			$options['Image_Height'] = $config['image_product_sku_size3_height'];

		}else if (in_array($Group, array('News_Ecom_Thumb'))) {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image1';
			$options['Image_Width'] = $config['image_news_ecom_thumb_width'];
			$options['Image_Height'] = $config['image_news_ecom_thumb_height'];

		}else if (in_array($Group, array('News_Ecom_Image'))) {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image2';
			$options['Image_Width'] = $config['image_news_ecom_image_width'];
			$options['Image_Height'] = $config['image_news_ecom_image_height'];

		}else if (in_array($Group, array('Banner_Footer_Image', 'Product_Sku_scr0', 'Product_Sku_scr1', 'Product_Sku_scr2', 'Product_Sku_scr3', 'Product_Sku_scr4'))) {
			$options['Crop_Thumb'] = false;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image';
			//$options['Image_Width'] = $config['image_banner_footer_image_width'];
			//$options['Image_Height'] = $config['image_banner_footer_image_height'];

		}else if (in_array($Group, array('Product_Sku_scr0', 'Product_Sku_scr1', 'Product_Sku_scr2', 'Product_Sku_scr3', 'Product_Sku_scr4'))) {
			$options['Crop_Thumb'] = false;
			$options['Fit_Image'] = false;
			$options['FieldName'] = 'Image_src';
			//$options['Image_Width'] = $config['image_banner_footer_image_width'];
			//$options['Image_Height'] = $config['image_banner_footer_image_height'];

		}else if ( $Group == 'News_Image2' || $Group == 'News_EN_Image2' || $Group == 'Knowledge_News_Image2' || $Group == 'Knowledge_Activity_Image2' || $Group == 'Section_News_Image2') {

			$options['Crop_Thumb'] = false;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'Image2';
			$options['Thumb_Width'] = 270;
			$options['Thumb_Height'] = 180;
			$options['Image_Width'] = 740;
			$options['Image_Height'] = 450;

		}else if ( $Group == 'Oursponsor') {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'Image';
			$options['Image_Width'] = 200;
			$options['Image_Height'] = 100;

		}else if ( $Group == 'Banner_Logo' || $Group == 'Banner_EN_Logo') {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'ImageLogo';
			$options['Image_Width'] = 203;
			$options['Image_Height'] = 68;

		}else if ( $Group == 'Banner_Head_Logo') {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'ImageLogo';
			$options['Image_Width'] = 950;
			$options['Image_Height'] = 198;
		}else if ( $Group == 'Alumni' || $Group == 'Instructor' || $Group == 'Committees') {
			
			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'Image';
			$options['Image_Width'] = 105;
			$options['Image_Height'] = 130;
			//echo $options['FieldName'];
			//exit();

		}else if ( $Group == 'Board_Image' || $Group == 'Board_EN_Image' || $Group == 'Advisory_Image' || $Group == 'Advisory_EN_Image' || $Group == 'Knowledge_Personnel_Image' || $Group == 'Section_Personnel_Image' || $Group == 'Head_Image' || $Group == 'Head_EN_Image') {

			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'Image';
			$options['Image_Width'] = 126;
			$options['Image_Height'] = 160;

		}else if ( $Group == 'Intro_Image') {
			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'Image';
			$options['Image_Width'] = 700;
			$options['Image_Height'] = 450;

		}

		if ( !empty($config['Image_Extension']) ) { $options['AllowedExtension'] = explode(',', str_replace(' ','',$config['Image_Extension'])); }
		$options['MaxFileSize'] = (int)$config['Image_Maxsize'];

	} else if ( in_array($Group, $GroupContent['Gallery']) ) {
		if($Group == 'News_Gallery' || $Group == 'News_Activity_Gallery' || $Group == 'News_Activity_EN_Gallery' || $Group == 'News_Events_Gallery' || $Group == 'Knowledge_Activity_Gallery' || $Group == 'Section_Activity_Gallery'){
			$options['Crop_Thumb'] = true;
			$options['Fit_Image'] = true;
			$options['FieldName'] = 'ImageGallery';
			$options['Total'] = 5;
			$options['Thumb_Width'] = 185;
			$options['Thumb_Height'] = 124;
			$options['Image_Width'] = 700;
			$options['Image_Height'] = 470;

		} elseif ( $Group == 'Gallery_big') {
			$options['Crop_Thumb'] = false;
			$options['Fit_Image'] = true;
			$options['Total'] = 30;
			$options['FieldName'] = 'ImageGallery';
			$options['Image_Width'] = 900;
			$options['Image_Height'] = 1350;
		}

	} else if ( in_array($Group, $GroupContent['Attach']) ) {
		$options['FieldName'] = 'Attach';
		if ( !empty($config['Attach_Extension']) ) { $options['AllowedExtension'] = explode(',', $config['Attach_Extension']); }
		$options['MaxFileSize'] = (int)$config['Attach_Maxsize'];
	}

	$options['MaxFileSize'] = chkMaxSize ( (int)$options['MaxFileSize'] );

	return $options;
}

function uploadImage($desFolder='.', $Group='', $ContentId=0, $options=array()) 
{
        global $ObjDB;

	IO::createFolder($desFolder);

	//Upload Image
	require_once(_MODULE.'/uploadfile.class.php');
	require_once(_MODULE.'/thumbnail.class.php');
	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( !empty($options['FieldName']) ? $options['FieldName'] : 'Image');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('jpg', 'jpeg', 'gif', 'png') );
	$objUpload->DestPath = $desFolder.'/';
	$objUpload->SaveToFolder = true;
	if ( $options['prefix'] ) $objUpload->FixedFileName = (int)$ContentId.'_'.$options['FieldName'].'_';
	$objUpload->UploadFiles = 1;
	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];
        
	//echo $options['Image_Width'].' || '.$options['Image_Height'];
        //exit();
        
	$objUpload->ProceedUpload();
	//myprint($objUpload->log);
	if( $objUpload->log['filename'][0] != '' ) 
        {

		if( (int)$options['Thumb_Width'] > 0  && (int)$options['Thumb_Height'] > 0 && $options['create_thump']) 
                {
			$objThumb = new Thumbnail( $objUpload->log['fullpath'][0] );

			/*$objThumb->crop_thumb = true;
			$objThumb->size_crop( (int)$options['Thumb_Width'], (int)$options['Thumb_Height'] );
			$objThumb->save();*/
			if ( !(bool)$options['Crop_Thumb'] ) 
                        {
                            $objThumb->crop_thumb = false;
                            $objThumb->size( (int)$options['Thumb_Width'], (int)$options['Thumb_Height'] );
			}
                        else 
                        {
                            $objThumb->crop_thumb = true;
                            $objThumb->crop_width = (int)$options['Thumb_Width'];
                            $objThumb->crop_height = (int)$options['Thumb_Height'];
			}
			$objThumb->save();

			// Resize Original Image
			if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) 
                        {
				list($width2, $height2, $type2, $attr2) = getimagesize( $objUpload->log['fullpath'][0] );
				if($width2 > (int)$options['Image_Width'] || $height2>(int)$options['Image_Height'])
                                {
					$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

					list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][0] );
					$objUpload->log['image_width'][0] = $width;
					$objUpload->log['image_height'][0] = $height;
				}
                                else
                                {
					$objThumb->resize_original_image( $width2, $height2, ((bool)$options['Fit_Image'] ? true : false) );

					list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][0] );
					$objUpload->log['image_width'][0] = $width;
					$objUpload->log['image_height'][0] = $height;
				}
			}
			$objThumb->destruct(); // Clear Resource

		}
                else 
                {
			$objThumb = new stdClass;

			// Resize Original Image
			if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) 
                        {

                                $width = (int)$options['Image_Width'];
                                $height = (int)$options['Image_Height'];
				$objThumb = new Thumbnail( $objUpload->log['fullpath'][0] );

				$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

				list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][0] );
				$objUpload->log['image_width'][0] = $width;
				$objUpload->log['image_height'][0] = $height;

				$objThumb->destruct(); // Clear Resource
			}
                        
			$objThumb->img = array('thumb_name'=> $objUpload->log['filename'][0], 'thumb_width'=>$objUpload->log['image_width'][0], 'thumb_height'=>$objUpload->log['image_height'][0]);
		}

		$values = array();
		$values['image_name'] = $objUpload->log['filename'][0];
		$values['image_width'] = (int)$objUpload->log['image_width'][0];
		$values['image_height'] = (int)$objUpload->log['image_height'][0];
		$values['thumb_name'] = $objThumb->img['thumb_name'];
		$values['thumb_width'] = (int)$objThumb->img['thumb_width'];
		$values['thumb_height'] = (int)$objThumb->img['thumb_height'];
                $values['type'] = encode_to_db($options['type']);
                $values['remark'] = encode_to_db(($options['remark']!=''?$options['remark']:''));
                
                
                if($options['img_id']!=''){  $where = ' and img_id = '.(int)$options['img_id'];  }
                
                if( !empty($options['type']) ){
                        $more_type = ' and `type` like \''.$options['type'].'\'';
                }else{
                        $more_type = '';
                }
                
		$query='SELECT `img_id`, `thumb_name`, `image_name` FROM '.T_IMAGE.' WHERE (`grp_content`=\''.encode_to_db($Group).'\' AND `content_id`='.(int)$ContentId.' '.$more_type.' '.$where.')';
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query image information', '', __LINE__, __FILE__, $query);}
                //exit($query);
		if($ObjDB->sql_numrows($result) == 0) {
			$values['grp_content'] = $Group;
			$values['content_id'] = (int)$ContentId;

			$query = $ObjDB->sql_build('INSERT', T_IMAGE, $values );


		} else {
			$data = $ObjDB->sql_fetchrow($result);
			// Delete Thumbnail
			if ( $data['thumb_name'] != $values['thumb_name'] ) IO::DeleteFile($desFolder, $data['thumb_name']);

			// Delete Image
			if ( $data['image_name'] != $values['image_name'] ) IO::DeleteFile($desFolder, $data['image_name']);

			$query = $ObjDB->sql_build('UPDATE', T_IMAGE, $values, '`img_id`='.(int)$data['img_id'], 1 );
		}

		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not insert/update image information', '', __LINE__, __FILE__, $query);}

		return '';
	} 
        else 
        {
		return $objUpload->log['status'][0];
	}
}

function uploadImageGallery($desFolder='.', $Group='', $ContentId=0, $options=array()) {
global $ObjDB;

	IO::createFolder($desFolder);

	//Upload Image
	require_once(_MODULE . '/uploadfile.class.php');
	require_once(_MODULE . '/thumbnail.class.php');
	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( !empty($options['FieldName']) ? $options['FieldName'] : 'Image');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('jpg', 'jpeg', 'gif', 'png') );
	$objUpload->DestPath = $desFolder .'/';
	$objUpload->SaveToFolder = true;
	if ( $options['prefix'] ) $objUpload->FixedFileName = (int)$ContentId.'_';
	$objUpload->UploadFiles = ( (int)$options['Total'] > 0 ? (int)$options['Total']: 1 );
	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];

	$objUpload->ProceedUpload();

	for($i=0; $i<count($objUpload->log['filename']); $i++) {
		if($objUpload->log['filename'][$i] != '') {

			// Create Thumbnail
			if( (int)$options['Thumb_Width'] > 0  && (int)$options['Thumb_Height'] > 0 ) {
				$objThumb = new Thumbnail( $objUpload->log['fullpath'][$i] );

				if ( !(bool)$options['Crop_Thumb'] ) {
					$objThumb->crop_thumb = false;
					$objThumb->size( (int)$options['Thumb_Width'], (int)$options['Thumb_Height'] );
				} else {
					$objThumb->crop_thumb = true;
					$objThumb->crop_width = (int)$options['Thumb_Width'];
					$objThumb->crop_height = (int)$options['Thumb_Height'];
				}
				$objThumb->save();

				// Resize Original Image
				if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) {
					list($width2, $height2, $type2, $attr2) = getimagesize( $objUpload->log['fullpath'][0] );
					if($width2>(int)$options['Image_Width'] || $height2>(int)$options['Image_Height']){
						$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

						list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][$i] );
						$objUpload->log['image_width'][$i] = $width;
						$objUpload->log['image_height'][$i] = $height;
					}else{
						$objThumb->resize_original_image( $width2, $height2, ((bool)$options['Fit_Image'] ? true : false) );

						list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][$i] );
						$objUpload->log['image_width'][$i] = $width;
						$objUpload->log['image_height'][$i] = $height;
					}
				}

				$objThumb->destruct(); // Clear Resource
			} else {
				$objThumb = new stdClass;
				//$objThumb->img = array('thumb_name'=>'', 'thumb_width'=>0, 'thumb_height'=>0);

				// Resize Original Image
				if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) {
					$objThumb = new Thumbnail( $objUpload->log['fullpath'][$i] );

					$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

					list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][$i] );
					$objUpload->log['image_width'][$i] = $width;
					$objUpload->log['image_height'][$i] = $height;

					$objThumb->destruct(); // Clear Resource
				}
				$objThumb->img = array('thumb_name'=> $objUpload->log['filename'][$i], 'thumb_width'=>$objUpload->log['image_width'][$i], 'thumb_height'=>$objUpload->log['image_height'][$i]);
			}

			$query='SELECT `img_id`, `thumb_name`, `image_name` FROM '.T_IMAGE.' WHERE (`grp_content`=\''.$Group.'\' AND `content_id`='.(int)$ContentId.') ORDER BY `ordering` DESC';
			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query image information", "", __LINE__, __FILE__, $query);}

			$values = array();
			$values['grp_content'] = $Group;
			$values['content_id'] = (int)$ContentId;
			$values['image_name'] = $objUpload->log['filename'][$i];
			$values['image_width'] = (int)$objUpload->log['image_width'][$i];
			$values['image_height'] = (int)$objUpload->log['image_height'][$i];
			$values['thumb_name'] = $objThumb->img['thumb_name'];
			$values['thumb_width'] = (int)$objThumb->img['thumb_width'];
			$values['thumb_height'] = (int)$objThumb->img['thumb_height'];
			$values['ordering'] = GetNextOrderId ( T_IMAGE, 'ordering', array('grp_content'=>$Group, 'content_id'=>$values['content_id'])  );
			$query = $ObjDB->sql_build('INSERT', T_IMAGE, $values );

			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't insert image information", "", __LINE__, __FILE__, $query);}

			unset($objThumb);
		}
	}
	unset($objUpload);
}

function uploadImageGallery2($desFolder='.', $Group='', $ContentId=0, $options=array()) {
global $ObjDB;

	IO::createFolder($desFolder);

	//Upload Image
	require_once(_MODULE . '/uploadfile.class.php');
	require_once(_MODULE . '/thumbnail.class.php');
	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( !empty($options['FieldName']) ? $options['FieldName'] : 'Image');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('jpg', 'jpeg', 'gif', 'png') );
	$objUpload->DestPath = $desFolder .'/';
	$objUpload->SaveToFolder = true;
	if ( $options['prefix'] ) $objUpload->FixedFileName = (int)$ContentId.'_';
	$objUpload->UploadFiles = ( (int)$options['Total'] > 0 ? (int)$options['Total']: 1 );
	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];

	$objUpload->ProceedUpload();

	for($i=0; $i<count($objUpload->log['filename']); $i++) {
		if($objUpload->log['filename'][$i] != '') {

			// Create Thumbnail
			if( (int)$options['Thumb_Width'] > 0  && (int)$options['Thumb_Height'] > 0 ) {
				$objThumb = new Thumbnail( $objUpload->log['fullpath'][$i] );

				if ( !(bool)$options['Crop_Thumb'] ) {
					$objThumb->crop_thumb = false;
					$objThumb->size( (int)$options['Thumb_Width'], (int)$options['Thumb_Height'] );
				} else {
					$objThumb->crop_thumb = true;
					$objThumb->crop_width = (int)$options['Thumb_Width'];
					$objThumb->crop_height = (int)$options['Thumb_Height'];
				}
				$objThumb->save();

				// big gallery
				/*$img = explode('.', $objUpload->log['fullpath'][$i]);
				copy($objUpload->log['fullpath'][$i], $img[0].'_big.'.$img[1] );
				$objThumb2 = new Thumbnail( $img[0].'_big.'.$img[1] );

				if ( !(bool)$options['Crop_Thumb'] ) {
					$objThumb2->crop_thumb = false;
					$objThumb2->size( (int)$options['Image_Width2'], (int)$options['Image_Height2'] );
				} else {
					$objThumb2->crop_thumb = true;
					$objThumb2->crop_width = (int)$options['Image_Width2'];
					$objThumb2->crop_height = (int)$options['Image_Height2'];
				}
				$objThumb2->save();*/

				// Resize Original Image
				if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) {
					$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

					list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][$i] );
					$objUpload->log['image_width'][$i] = $width;
					$objUpload->log['image_height'][$i] = $height;
				}
				unlink($img[0].'_big.'.$img[1]);
				$objThumb->destruct(); // Clear Resource
			} else {
				$objThumb = new stdClass;
				//$objThumb->img = array('thumb_name'=>'', 'thumb_width'=>0, 'thumb_height'=>0);

				// big gallery
				/*$img = explode('.', $objUpload->log['fullpath'][$i]);
				copy($objUpload->log['fullpath'][$i], $img[0].'_big.'.$img[1] );
				$objThumb2 = new Thumbnail( $img[0].'_big.'.$img[1] );

				if ( !(bool)$options['Crop_Thumb'] ) {
					$objThumb2->crop_thumb = false;
					$objThumb2->size( (int)$options['Image_Width2'], (int)$options['Image_Height2'] );
				} else {
					$objThumb2->crop_thumb = true;
					$objThumb2->crop_width = (int)$options['Image_Width2'];
					$objThumb2->crop_height = (int)$options['Image_Height2'];
				}
				$objThumb2->save();*/

				// Resize Original Image
				if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) {
					$objThumb = new Thumbnail( $objUpload->log['fullpath'][$i] );

					$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

					list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][$i] );
					$objUpload->log['image_width'][$i] = $width;
					$objUpload->log['image_height'][$i] = $height;

					$objThumb->destruct(); // Clear Resource
				}
				$objThumb->img = array('thumb_name'=> $objUpload->log['filename'][$i], 'thumb_width'=>$objUpload->log['image_width'][$i], 'thumb_height'=>$objUpload->log['image_height'][$i]);
			}

			$query='SELECT `img_id`, `thumb_name`, `image_name` FROM '.T_IMAGE.' WHERE (`grp_content`=\''.$Group.'\' AND `content_id`='.(int)$ContentId.') ORDER BY `ordering` DESC';
			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query image information", "", __LINE__, __FILE__, $query);}

			$img_name = explode('/', $img[0]);

			$values = array();
			$values['grp_content'] = $Group;
			$values['content_id'] = (int)$ContentId;
			$values['image_name'] = $objUpload->log['filename'][$i];
			$values['image_width'] = (int)$objUpload->log['image_width'][$i];
			$values['image_height'] = (int)$objUpload->log['image_height'][$i];
			$values['thumb_name'] = $objThumb->img['thumb_name'];
			$values['thumb_width'] = (int)$objThumb->img['thumb_width'];
			$values['thumb_height'] = (int)$objThumb->img['thumb_height'];
			/*$values['image_name2'] = $img_name[count($img_name)-1].'_big_thumb.'.$img[1];
			$values['image_width2'] = (int)$options['Image_Width2'];
			$values['image_height2'] = (int)$options['Image_Width2'];*/
			$values['ordering'] = GetNextOrderId ( T_IMAGE, 'ordering', array('grp_content'=>$Group, 'content_id'=>$values['content_id'])  );
			$query = $ObjDB->sql_build('INSERT', T_IMAGE, $values );

			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't insert image information", "", __LINE__, __FILE__, $query);}

			// big gallery


			/*$values = array();
			$values['grp_content'] = $Group.'_big';
			$values['content_id'] = (int)$ContentId;

			$values['ordering'] = GetNextOrderId ( T_IMAGE, 'ordering', array('grp_content'=>$Group.'_big', 'content_id'=>$values['content_id'])  );
			$query = $ObjDB->sql_build('INSERT', T_IMAGE, $values );

			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't insert image information", "", __LINE__, __FILE__, $query);}
		*/

			unset($objThumb);
		}
	}
	unset($objUpload);
}

function deleteImage($desFolder='', $Group='', $ContentId=0, $Id=0) {
global $ObjDB;
	// Create Folder if not exists
	//IO::createFolder($desFolder);

	if ( is_array($Group) ){
		$Condition = '`grp_content` IN (\''.implode('\', \'', $Group['grp_content']).'\')';
	} else {
		$Condition = '`grp_content`=\''.$Group.'\'';
	}

	if($ContentId != 0) $Condition .= ' AND `content_id`='.(int)$ContentId;
	if($Id != 0) $Condition .= ' AND `img_id`='.(int)$Id;

	$query='SELECT `img_id`, `thumb_name`, `image_name` FROM '.T_IMAGE.' WHERE ('.$Condition .')';
	
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query image information', '', __LINE__, __FILE__, $query);}
	if( $ObjDB->sql_numrows($result) != 0) {
		while($data = $ObjDB->sql_fetchrow($result)) {
			// Delete Thumb
			IO::DeleteFile($desFolder, $data['thumb_name']);
			// Delete Image
			IO::DeleteFile($desFolder, $data['image_name']);
			//IO::DeleteFile($desFolder, $data['image_name2']);
		}
		$query='DELETE FROM '.T_IMAGE.' WHERE ('.$Condition.')';
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not delete image information', '', __LINE__, __FILE__, $query);}
	}
}

function uploadAttach($desFolder='.', $Group='', $ContentId=0, $options=array(), $Ordering=0) {
global $ObjDB;
	// Create Folder if not exists
	IO::createFolder($desFolder);

	//Upload Files
	require_once(_MODULE . '/uploadfile.class.php');
	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( isset($options['FieldName']) ? $options['FieldName'] : 'File');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('pdf', 'txt', 'doc', 'xls', 'ppt', 'swf', 'zip', 'mp3') );
	$objUpload->DestPath = $desFolder .'/';
	$objUpload->SaveToFolder = true;
	if ( $options['prefix'] ) $objUpload->FixedFileName = ((int)$ContentId).'_'.$options['FieldName'].'_';
	$objUpload->UploadFiles = ( (int)$options['Total'] > 0 ? (int)$options['Total']: 1 );
	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];

	$objUpload->ProceedUpload();

	for($i=0; $i<count($objUpload->log['filename']); $i++) {
		if($objUpload->log['filename'][$i] != '') {
			if ( $Ordering != 0 ) {
				$query='SELECT `att_id`, `filename` FROM '.T_ATTACH.' WHERE (`grp_content`=\''.encode_to_db($Group).'\' AND `content_id`='.(int)$ContentId.')';
				
				if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query attach file information', '', __LINE__, __FILE__, $query);}
				if($ObjDB->sql_numrows($result) == 0) {
					$values = array();
					$values['grp_content'] = $Group;
					$values['content_id'] = (int)$ContentId;
					$values['filename'] = $objUpload->log['filename'][$i];
					$values['filemime'] = $objUpload->log['mime_type'][$i];
					$values['filesize'] = $objUpload->log['size'][$i];
					$values['extension'] = $objUpload->log['ext_type'][$i];
					$values['ordering'] = (int)$Ordering;
					$query = $ObjDB->sql_build('INSERT', T_ATTACH, $values );

				} else {
					while($data = $ObjDB->sql_fetchrow($result)) {
						// Delete Attach
						/*echo "log file >> ".$objUpload->log['filename'][0];
						echo "<br/> filename >> ".$data['filename'];
						exit();*/
						if ( $objUpload->log['filename'][0] != $data['filename'] ) IO::DeleteFile($desFolder, $data['filename']);
					}
					$values = array();
					$values['filename'] = $objUpload->log['filename'][$i];
					$values['filemime'] = $objUpload->log['mime_type'][$i];
					$values['filesize'] = $objUpload->log['size'][$i];
					$values['extension'] = $objUpload->log['ext_type'][$i];
					$query = $ObjDB->sql_build('UPDATE', T_ATTACH, $values, '`grp_content`=\''.encode_to_db($Group).'\' AND `content_id`='.(int)$ContentId/*.' AND `ordering`='.(int)$Ordering, 1*/ );
				}
			} else {
				$values = array();
				$values['grp_content'] = $Group;
				$values['content_id'] = (int)$ContentId;
				$values['filename'] = $objUpload->log['filename'][$i];
				$values['filemime'] = $objUpload->log['mime_type'][$i];
				$values['filesize'] = $objUpload->log['size'][$i];
				$values['extension'] = $objUpload->log['ext_type'][$i];
				$values['ordering'] = GetNextOrderId ( T_ATTACH, 'ordering', array('grp_content'=>$Group, 'content_id'=>(int)$ContentId)  );
				$query = $ObjDB->sql_build('INSERT', T_ATTACH, $values );
			}
			if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not insert attach file information', '', __LINE__, __FILE__, $query);}
		//echo $query;exit;
		}
	}
}

function deleteAttach($desFolder='', $Group='', $ContentId=0, $Id=0) {
global $ObjDB;

	if ( is_array($Group) ){
		$Condition = '`grp_content` IN (\''.implode('\', \'', $Group).'\')';
	} else {
		$Condition = '`grp_content`=\''.$Group.'\'';
	}

	if($ContentId != 0) $Condition .= ' AND `content_id`='.(int)$ContentId;
	if($Id != 0) $Condition .= ' AND `att_id`='.(int)$Id;

	$query='SELECT `att_id`, `filename` FROM `'.T_ATTACH.'` WHERE ('.$Condition .')';
	//echo $query;exit;
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query attachment information", "", __LINE__, __FILE__, $query);}
	if( $ObjDB->sql_numrows($result) != 0) {
		while($data = $ObjDB->sql_fetchrow($result)) {
			// Delete File
			IO::DeleteFile($desFolder, $data['filename']);
		}
		$query='DELETE FROM `'.T_ATTACH.'` WHERE ('.$Condition.')';
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't delete attachment information", "", __LINE__, __FILE__, $query);}
	}
}

function uploadFile($desFolder='.', $options=array()) {
global $ObjDB;

	IO::createFolder($desFolder);

	//Upload Image
	require_once(_MODULE . '/uploadfile.class.php');

	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( !empty($options['Fieldname']) ? $options['Fieldname'] : 'Image');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('jpg', 'jpeg', 'gif', 'png') );
	$objUpload->DestPath = $desFolder .'/';
	$objUpload->SaveToFolder = true;
	$objUpload->UploadFiles = 1;
	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];

	$objUpload->ProceedUpload();
	if( $objUpload->log['filename'][0] != '' ) {
		return '';
	} else {
		return $objUpload->log['status'][0];
	}
}

function SortOrdering($TBName='', $FId='Id', $FOrder='Ordering', $Condition=array()) {
global $ObjDB;
	$strCondition='';
	//echo '# SortOrdering #<br />';
	if(!empty($Condition)) {
		$BuildCondition= array();
		while(list($Field, $Value) = each($Condition)) $BuildCondition[] = '`'.$Field.'`=\''.$Value.'\'';
		$strCondition = ' WHERE ('.implode(' AND ', $BuildCondition) .')';
	}

	$query = 'SELECT `'.$FId.'` FROM '.$TBName.' '.$strCondition.' ORDER BY `'.$FOrder.'` ASC';
	
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query table information", "", __LINE__, __FILE__, $query);}
	if($ObjDB->sql_numrows($result) != 0) {
		$Order=0;
		while($data = $ObjDB->sql_fetchrow($result)) {
			$Order += 10;
			$query = 'UPDATE '.$TBName.' SET `'.$FOrder.'`='.$Order.' WHERE (`'.$FId.'`='.$data[$FId].') LIMIT 1';
			
			$ObjDB->sql_query($query);
		}
	}
	//exit;
}

function genFieldSorting ( $title='', $field_name, $param=array(),$alt='') {
	global $clsSession;

	$sort_mode = ( $clsSession->get_param('sort_by') == $field_name && strtolower($clsSession->get_param('sort_mode')) == 'asc' ? 'desc' : 'asc');

	$param['add']['sort_by'] = $field_name;
	$param['add']['sort_mode'] = $sort_mode;

	if( !in_array('sort_by', $param['ignore']) ) $param['ignore'][] = 'sort_by';
	if( !in_array('sort_mode', $param['ignore']) ) $param['ignore'][] = 'sort_mode';

	$baseUrl = buildParam( $param );
	return '<a href="'.$baseUrl.'" title="'.$alt.'">'.$title.'</a>'.( $clsSession->get_param('sort_by') == $field_name ? '<img src="images/s_'.$sort_mode.'.gif" alt="" title="'.$alt.'" />' : '');
}

function isValidEmail($email){
	//return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);

	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function JSON_print($result, $child = false){
 foreach($result as $key => $val)
 {
  $is_child = 0;
  if(is_array($val)){ $AjaxReturn[] = JSON_print($val,true); $is_child++;}
  else $AjaxReturn[] = "'" . $key . "' : '" . decode_from_db($val)."'";
  //$AjaxReturn[] = '\'' . $val['id'] . '\' : \'' . $val['title'].'\'';
 }

 $return_json = $is_child > 0? '['.implode(', ',$AjaxReturn).']' : '{'.implode(', ',$AjaxReturn).'}';

 if($child) return $return_json;
 else print $return_json;

 //exit;
}

function getStatusByOrder($status=0) {

	switch ($status) {
		case 1:
			$status_text = "สั่งซื้อ (โอนเงิน)";
			break;
		case 2:
			$status_text = "สั่งซื้อ(credit)";
			break;
		case 3:
			$status_text = "ได้รับเงินแล้ว";
			break;
		case 4:
			$status_text = "จัดส่งสินค้าแล้ว";
			break;
		case 5:
			$status_text = "สินค้าเกินลิมิต";
			break;
		case 6:
			$status_text = "ยืนยันใบ order เกินลิมิต";
			break;
		case 7:
			$status_text = "ยกเลิกใบ order เกินลิมิต";
			break;

	}
	return $status_text;
}

function count_HotPromotion(){
	global $ObjDB;

	$Condition = array();
	$Condition[] = '(`p`.`published` =1 )';
	$Condition[] = '(`p`.`hot_promotion` = 1 )';
	$Condition[] = '(`p`.`date_active` <= CURDATE() AND `p`.`date_expired` >= CURDATE() )';
	if(count($Condition)==0) $Condition[] = '1';
	$strCond = implode(' AND ', $Condition);

	$query = 'SELECT count(p.psku_id) As Total ';
	$query.= 'FROM '.T_PRODUCT_SKU.' AS p  ';
	$query.= 'WHERE ('.$strCond.') ';

	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query count hot promotion information", "", __LINE__, __FILE__, $query);}
	$data = $ObjDB->sql_fetchrow($result);
	$val = $data['Total'];
	return $val;

}

function get_payment_type_be($type) {
	$string = '&nbsp;';
	switch((int)$type) {
		case 1: $string = 'บัตรเครดิต'; break;
		case 2: $string = 'โอนเงิน'; break;
                case 5: $string = 'ใช้คะแนน'; break;
                case 9: $string = 'จ่ายแทนเงินสดด้วยคูปอง'; break;
	}
	return $string;
}

function chk_status_be($status, $type) {
	$string = '&nbsp;';
        if( $type == 5){
            if((int)$status == 6)
            {
                return 'จัดส่งของสมนาคุณแล้ว';
            }
            elseif( (int)$status == 9 )
            {
                return 'ยกเลิกรายการแลกของ';
            }
            elseif( (int)$status == 7) 
            {
                return 'เช็ค Stock ของสมนาคุณ';
            }
            else
            {
               return 'รายการแลกของ'; 
            }
            
        }else{
            switch((int)$status) {
		case 1: $string = 'สั่งซื้อสินค้า'; break;
		case 2: $string = 'แจ้งชำระเงิน'; break;
		case 3: $string = 'ตรวจสอบชำระเงินแล้ว'; break;
		case 4: $string = 'รอการจัดส่ง'; break;
		case 5: $string = 'รอการจัดส่ง'; break;
		case 6: $string = 'จัดส่งสินค้าแล้ว'; break;
		case 7: $string = 'รอยืนยันจากไลอ้อน'; break;
		case 8: $string = 'ออเดอร์ใหม่'; break;
		case 9: $string = 'ยกเลิกการสั่งซื้อ'; break;
            }
        }
	
	return $string;
}

function get_title_unit_be($title='', $unit=''){
	$text = $title;
	if(!empty($unit)){
		$text = $title.' ('.$unit.')';
	}
	return $text;
}

function get_order($order_id=0, $params=array())
{
    global $ObjDB;
	$Content = array();

	$Condition = array();
	$Condition[] = '`o`.`order_id`='.(int)$order_id;
	if (!empty($params)) {
		foreach($params as $key=>$value) {
			if ($key=='status') {
				if (is_array($value)) {
					$Condition[] = '`o`.`status` IN ('.implode(', ', $value).')';
				} else {
					$Condition[] = '`o`.`status`='.(int)$value;
				}
			} else {
				$Condition[] = '`o`.`'.$key.'`=\''.encode_to_db($value).'\'';
			}
		}
	}
	$strCond = implode(' AND ', $Condition);

	$query = 'SELECT `o`.* ,o.total as total_not_discount ,IF((`o`.`total` < `o`.`total_discount`),0,(`o`.`total` - `o`.`total_discount`)) AS `total` ,(`o`.`total` - `o`.`total_discount`) AS `total_price` ';
	$query.= ', DATE_FORMAT(`o`.`date_purchase`,\'%d/%m/%Y %H:%i\') AS `purchase_date` , mem.member_user as invite_user_name';
	$query.= ', DATE_FORMAT(`o`.`date_invoice`,\'%d/%m/%Y\') AS `invoice_date` , o.invite_to_bought ';
	$query.= ', DATE_FORMAT(`o`.`date_delivery`,\'%d/%m/%Y\') AS `delivery_date` , o.gold_coin ,p.psku_id as sku_to_free
                    ,sum((op.pay_point*op.value)) as paywithpoint ,sum( if(op.pay_point = 0,op.price,0) ) as total_money ';
	$query.= ', `m`.`member_user`, TRIM(CONCAT(`m`.`member_fname`, \' \', `m`.`member_lname`)) AS `member_name`, `m`.`member_mobile`, `m`.`member_email`,IF(`o`.`total`<=0,1,0) AS `zero_con` 
	,sum(op.pay_point * op.value) as paywithpoint ,o.birthday ,o.birth_day ,( select count(o_pay.order_payment_id) from '.T_ORDER_PAYMENT.' as o_pay where o.order_id = o_pay.order_id group by o.order_id limit 1) as paymeny_count';
	$query.= ' FROM '.T_ORDER.' AS `o` ';
	$query.= ' LEFT JOIN '.T_MEMBER.' AS `m` ON (`o`.`member_id`=`m`.`member_id`) 
                    left join '.T_MEMBER.' as `mem` ON (mem.member_id = o.invite_to_bought)
                    left join '.T_PRODUCT_ORDER.' as op on o.order_id=op.order_id
                    left join '.T_PROMOTION.' as p on (p.promotion_id = o.promotion_id) ';
	$query.= ' WHERE ('.$strCond.') group by o.order_id 
            LIMIT 1 ';
	if (!($result = $ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query);}
	if ($ObjDB->sql_numrows($result) != 0) {
		
		while( $temp = $ObjDB->sql_fetchrow($result) )
                {
				if( $temp['birthday']==1 ){
                                        $temp['gold_coin_with_bonus']	= (int)($temp['gold_coin'] * $temp['birth_day']);//( birthday_bunus($temp['gold_coin']) );
				}else{
                                        $temp['gold_coin_with_bonus'] = $temp['gold_coin'];
				}
				if( ($temp['total_money']==0 && $temp['paywithpoint']>0) || ( $temp['total_discount'] > 0 && $temp['total']<=0 ) ){
                                        $temp['bt_approve'] = true;
				}else{
                                        $temp['bt_approve'] = false;
				}
                                $temp['all_point'] = ($temp['total_money']==0 && $temp['paywithpoint'] > 0?true:false);
                                $temp['all_coupon'] = ($temp['total']==0 ?true:false);
                                
                                if($temp['ro_code']!='') 
                                {
                                    $temp['order_code'] = decode_from_db($temp['ro_code']);
                                }
                                
				$Content = $temp;
				
		}
                
		$Content['total_tax'] 	= $Content['total_price_no_tax'] = 0;
		$Content['total_price'] = $temp['total_not_discount'];
		if (in_array($Content['status'], array(1,2,3))) {// 3 mod by ake
			$query = 'SELECT SUM(`payment_amount`) AS `payment_amount` FROM '.T_ORDER_PAYMENT.' WHERE (`order_id`='.(int)$Content['order_id'].')';
			if (!($result=$ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Could not query order payment information', '', __LINE__, __FILE__, $query);}
			
			while( $temp = $ObjDB->sql_fetchrow($result) ){
                            $data = $temp;
			}
                    $Content['c_payment_amount'] = $data['payment_amount'];
		}

		// GET Products Order
		$query = 'SELECT `a`.`psku_id`,`a`.`component_id`, `a`.`product_code`, `a`.`product_title_th` AS `title_th`, `a`.`product_title_en` AS `title_en`, `a`.`product_description_th` AS `description_th`, `a`.`product_description_en` AS `description_en`, `a`.`unit_th`, `a`.`unit_en`, `a`.`value` AS `amount`, `a`.`price`, (`a`.`value` * `a`.`price`) AS `total_price`, `b`. `type`,`b`.`pcat_id` , `b`.`unit_sku`';
		$query.= ', `d`.`image_name`, `d`.`image_width`, `d`.`image_height` ,(a.point_special * a.value) as extrapoint ,a.point_special, a.pay_point';
		$query.= ', `e`.`image_name` AS `c_image_name` , `e`.`image_width` AS `c_image_width`
		, `e`.`image_height` AS `c_image_height`, (a.value * a.pay_point) as total_point_each 
		,if(a.pay_point > 0,1,0) as pay_with_point ';
		$query.= ' FROM '.T_PRODUCT_ORDER.' AS `a` ';
		$query.= 'LEFT JOIN '.T_PRODUCT_SKU.' AS `b` ON (`a`.`psku_id`=`b`.`psku_id`) ';
		$query.= 'LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`b`.`psku_id`) ';
		$query.= 'LEFT JOIN '.T_IMAGE.' AS `e` ON (`e`.`grp_content`=\'Product_Sku_Thumb\' AND `e`.`content_id`=`a`.`component_id` ) ';
		$query.= 'WHERE (`order_id`='.(int)$Content['order_id'].') ';
                $query.= ' ORDER BY '.cart_ordering_product('a').' ';
		
		if (!($result=$ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $query);}

		$product = array();
		$p_component = array();

		if ($ObjDB->sql_numrows($result) != 0) 
                {
			while ($data = $ObjDB->sql_fetchrow($result))
                        {
				if($data['component_id'] == '0' )
                                {
					$data['image_url'] = BASEURL.'/images/default_image_1.gif';
					if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) 
                                        {
						$data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
						$_arr = IO::autoImageSize($data['image_width'], $data['image_height'], 80, 60);
						$data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
					} 
                                        else 
                                        {
						$data['image_width'] = 80; $data['image_height'] = 60;
					}
                                        $data['disable'] = status_sku_text($data['psku_id'],1);
					$product[] = $data;

				}
                                else
                                {
					$data['image_url'] = BASEURL.'/images/default_image_1.gif';
					if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['c_image_name'])) 
                                        {
						$data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['c_image_name'];
						$_arr = IO::autoImageSize($data['c_image_width'], $data['c_image_height'], 80, 60);
						$data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
					} 
                                        else 
                                        {
						$data['image_width'] = 80; $data['image_height'] = 60;
					}
                                        $data['unit_sku'] = get_sku_unit($data['component_id']);
					$p_component[$data['psku_id']][] = $data;
				}
                                $Content['sum_paywith_point'] += (int)$data['total_point_each'];
			}

			foreach ($product as $item)
                        {
				if (!empty($p_component[$item['psku_id']])){
					$item['components'] = $p_component[$item['psku_id']];
				}
				$Content['Products'][] = $item;
			}
			
		}

		if ($Content['shipping'] > 0) {
			$Content['total_tax']+= ($Content['shipping']*7)/107;
		}
		foreach($Content['Products'] as $i=>$item) {
			$Content['total_tax']+= ($item['total_price']*7)/107;
			$Content['total_price']+= $item['total_price'];
		}
                
                (float)$Content['grand_total'] = $Content['total']; //- $Content['total_discount'];
                
                // + (float)$Content['total_tax'] - (float)$Content['total_discount']
                if($Content['grand_total']<0) $Content['grand_total']=0;
				$Content['total_price_no_tax'] = $Content['total_not_discount'] - $Content['total_tax'];
				$Content['total_price_with_tax'] = $Content['total_not_discount'];
                
                if($Content['grand_total']==0){// AKE MOD
                        $Content['total_price_no_tax'] = $Content['total'] - $Content['total_tax'];
                }
                    
		// GET Discount Coupon
		$query = 'SELECT * FROM '.T_ORDER_COUPON.' WHERE (`order_id`='.(int)$Content['order_id'].') ORDER BY `order_coupon_id`';
		if (!($result=$ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Could not query coupon order information', '', __LINE__, __FILE__, $query);}
		$Content['coupon'] = $ObjDB->sql_fetchrow($result);

		// GET Address
		$query = 'SELECT `a`.*, TRIM(CONCAT(`a`.`porder_fname`, \' \', `a`.`porder_lname`)) AS `porder_name`, TRIM(CONCAT(`a`.`shipping_fname`, \' \', `a`.`shipping_lname`)) AS `shipping_name` , `b`.`location_delivery` 
		FROM '.T_ORDER_ADDRESS.' AS `a` 
		LEFT JOIN '.T_ORDER.' AS `b` ON(`a`.`order_id` = `b`.`order_id`) 
		WHERE (`a`.`order_id`='.(int)$Content['order_id'].') LIMIT 1';
		if (!($result=$ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Could not query address order information', '', __LINE__, __FILE__, $query);}
		if ($ObjDB->sql_numrows($result) != 0) {
			$Content['Address'] = $ObjDB->sql_fetchrow($result);
		}

		$address = array();
		$address['name'] = decode_from_db($Content['Address']['porder_name']);
		$address['address'] = decode_from_db($Content['Address']['porder_address']);
		$address['moo'] = decode_from_db($Content['Address']['porder_moo']);
		$address['addr_type'] = decode_from_db($Content['Address']['porder_addr_type']);
		$address['soi'] = decode_from_db($Content['Address']['porder_soi']);
		$address['road'] = decode_from_db($Content['Address']['porder_road']);
		$address['tambon'] = decode_from_db($Content['Address']['porder_tambon']);
		$address['amphur'] = decode_from_db($Content['Address']['porder_aumphur']);
		$address['province'] = decode_from_db($Content['Address']['porder_province']);
		$address['postcode'] = decode_from_db($Content['Address']['porder_postcode']);
		$address['phone'] = decode_from_db($Content['Address']['porder_phone']);
		$address['mobile'] = decode_from_db($Content['Address']['porder_mobile']);
		$Content['address_tax'] = concatAddress2($address);

		$address = array();
		$address['name'] = decode_from_db($Content['Address']['shipping_name']);
		$address['name'] = trim(decode_from_db($Content['Address']['shipping_fname'].' '.$Content['Address']['shipping_lname']));
		$address['address'] = decode_from_db($Content['Address']['shipping_address']);
		$address['moo'] = decode_from_db($Content['Address']['shipping_moo']);
		$address['addr_type'] = decode_from_db($Content['Address']['shipping_addr_type']);
		$address['soi'] = decode_from_db($Content['Address']['shipping_soi']);
		$address['road'] = decode_from_db($Content['Address']['shipping_road']);
		$address['tambon'] = decode_from_db($Content['Address']['shipping_tambon']);
		$address['amphur'] = decode_from_db($Content['Address']['shipping_aumphur']);
		$address['province'] = decode_from_db($Content['Address']['shipping_province']);
		$address['postcode'] = decode_from_db($Content['Address']['shipping_postcode']);
		$address['phone'] = decode_from_db($Content['Address']['shipping_phone']);
		$address['location_delivery'] = decode_from_db($Content['Address']['location_delivery']);
		$address['mobile'] = decode_from_db($Content['Address']['shipping_mobile']);
		$Content['address_delivery'] = concatAddress2($address);
	}

	return $Content;
}

function get_product_specialset_component($special_set_id=0,$qty=1,$order_id=0) {
	global $ObjDB;

        if($order_id>0)
            $order_query = ',(SELECT `value` from '.T_PRODUCT_ORDER.' where order_id = '.$order_id.' AND `component_id` = `a`.`product_id`) AS `last_order`';
        
	$Content = array();
	// GET Component Information
	$query = ' SELECT b.*, `us`.`username` AS user_name ,`b`.`title_th`,(`b`.`amount`) AS `stock_balance`,`d`.*,`a`.*,(`a`.`product_id`) AS `psku_id` 
            , (`a`.`detail_th`) AS `description_th` ,(`a`.`detail_en`) AS `description_en` 
            , (`u`.`title_th`) AS `unit_th` , (`u`.`title_en`) AS `unit_en`,`a`.`special_set_id` AS `main_set_id`
            ,IF((b.published=1 and (CURDATE() BETWEEN date(b.date_active) AND date(b.date_expired) )),1,0) AS flag_activate ';
	$query.= $order_query;
	$query.= ' FROM '.T_PRODUCT_SPECIALSET.'AS `a`';
	$query.= ' LEFT JOIN '.T_PRODUCT_SKU.' AS `b` ON (`a`.`product_id`=`b`.`psku_id`) ';
	$query.= ' LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`b`.`psku_id`) ';
	$query.= ' LEFT JOIN '.T_UNIT.' AS `u` ON (`u`.`unit_id` = `b`.`unit_id`)
                    LEFT JOIN '.T_USER.' AS `us` ON  (`us`.`user_id` = `b`.`user_modify`) ';
	$query.= ' WHERE special_set_id = '.$special_set_id;
	$query.= ' ORDER BY `b`.`psku_id` ASC ';

	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query product speical set component information', '', __LINE__, __FILE__, $query);}
	while($data = $ObjDB->sql_fetchrow($result)){
            $data['image_url'] = BASEURL.'/images/default_image_1.gif';
				if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) {
					$data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
					$_arr = IO::autoImageSize($data['image_width'], $data['image_height'], 80, 60);
					$data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
				} else {
					$data['image_width'] = 80; $data['image_height'] = 60;
				}
            $data['order_quantity'] = ($data['quantity']*$qty);
            $data['total_order_value'] = ($data['order_quantity']*$data['price']);
            $data['title_th_sta'] = $data['title_th'].'<br />'.status_sku_text($data['psku_id']);
            $Content[] = $data;
	}
        if( empty($Content))
            unset($Content);
	return $Content;
}

function get_order_payment($order_id=0)
{
    global $ObjDB;
	$Content = array();

	// GET Payment Information
	$query = 'SELECT `op`.*, (`op`.`date_create`) AS `payment_full_date`';
	$query.= ', `a`.`filename`, `a`.`filemime`,(`op`.`time_payment`) AS `time_payment`, TIME(`op`.`date_create`) AS `time_backup`,DATE(`op`.`date_create`) as `date_backup`
            ,(if(b.bank_id=4,1,0)) as pay_way , `us`.name as create_payment_name';
	$query.= ', `b`.`bank_name_th` AS `bank_name`, `b`.`branch_name_th` AS `branch_name`,`us`.`name` ';
	$query.= 'FROM '.T_ORDER_PAYMENT.' AS `op` ';
	$query.= 'LEFT JOIN '.T_BANK.' AS `b` ON (`b`.`bank_id`=`op`.`bank_id`) ';
	$query.= 'LEFT JOIN '.T_ATTACH.' AS `a` ON (`op`.`order_payment_id`=`a`.`content_id` AND `a`.`grp_content`=\'Payment\') ';
	$query.= 'LEFT JOIN '.T_USER.' AS `us` ON (`us`.`user_id`=`op`.`user_create`) ';
	$query.= 'WHERE (`op`.`order_id`='.(int)$order_id.') ';
	$query.= 'ORDER BY `op`.`order_payment_id` ASC ';

	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query order payment information', '', __LINE__, __FILE__, $query);}
	while($data = $ObjDB->sql_fetchrow($result))
        {
                if($data['pay_way']==1 || $data['payment_type']==1)
                 {
                    if( (int)$data['user_create'] > 0 )
                    {
                            $data['create_by'] = decode_from_db( $data['create_payment_name'] );
                    }
                    else
                    {
                            $data['create_by'] = 'K-Bank (GATEWAY)';
                    }
                }
                else if($data['user_create']>0)
                {
                    $data['create_by'] = 'Admin '.get_username((int)$data['user_create']);
                }
                else
                {
                    $data['create_by'] = 'Member';
                }
                
		#time_payment_only
                /*if( empty($data['payment_date']) || $data['payment_date']=='0000-00-00')
                 {
                    $data['payment_date'] = $data['date_backup'];
                 }
                 */
                
                
		if ($data['payment_type'] == 1) 
                {
                    $data['credit_card'] = true;
                    $data['payment_type'] = 'ชำระผ่านบัตรเครดิต';
                    $data['payment_transfer'] = decode_from_db($data['bank_name'].' : '.$data['branch_name']);

                    if($data['payment_full_date'] !='' && $data['payment_full_date'] != '0000-00-00 00:00:00')
                    {
                        $data['date_payment_only'] = date("j/m/Y",strtotime($data['payment_full_date']));
                        $data['time_payment_only'] = date("H:i:s",strtotime($data['payment_full_date']));
                    }
                    else
                    {
                        $data['date_payment_only'] = 'invalid date format';
                        $data['time_payment_only'] = 'invalid date format';
                    }
		} 
                else if ($data['payment_type'] == 2 || $data['payment_type'] == 0) 
                {
                    $data['payment_type'] = 'โอนเงินผ่านธนาคาร';
                    $data['payment_transfer'] = decode_from_db($data['bank_name'].' : '.$data['branch_name']);

                    $data['date_payment_only']		= date("j/m/Y",strtotime($data['date_payment']));
                    $data['time_payment_only'] = ( ($data['time_payment'] == '00 : 00') ? date("H:i",strtotime($data['payment_full_date'])):$data['time_payment']);

		}
		
		
		if( empty($data['time_payment']) )
                {
                    //$data['time_payment'] = $data['time_backup'];
		}
                
                
		$Content[] = $data;
	}

	return $Content;
}

function get_payment_type($payment_id){
	if ((int)$payment_id==1){
		$text = "บัตรเครดิต";
	} else if((int)$payment_id==2){
		$text = "โอนเงิน";
	} else {
		$text = $payment_id;
	}
	return $text;
}

function count_HightlightNews(){
	global $ObjDB;

	$Condition = array();
	$Condition[] = '(`n`.`published` =1 )';
	$Condition[] = '(`n`.`highlight` =1 )';
	$Condition[] = '(`n`.`date_active` <= CURDATE() AND `n`.`date_expired` >= CURDATE() )';
	if(count($Condition)==0) $Condition[] = '1';
	$strCond = implode(' AND ', $Condition);

	$query = 'SELECT count(n.news_id) As Total ';
	$query.= 'FROM '.T_NEWS_ECOM.' AS n  ';
	$query.= 'WHERE ('.$strCond.') ';

	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query count hightlignt news information", "", __LINE__, __FILE__, $query);}
	$data = $ObjDB->sql_fetchrow($result);
	$val = $data['Total'];
	return $val;

}

function update_home_product_ordering($arr_ordering=array(),$method=0) 
{
        global $ObjDB;
        if($method == 2)
        {
          $addition = ', home_type = 2 ';   // normal sku
        }
        else if($method == 1)
        {
            $addition = ' , home_type = 1 ';   // hot promotion
        }
        else if($method == 3)
        {
            $addition = ' , `pcat_id` = 7 , home_type = 3 ';  //special set
        }
        else if($method == 4)
        {
            $addition = ' , home_type = 5 ';  // Cosmetic and Cosmetic import and export
        }
        else if($method == 5)
        {
            $addition = ' , `ptype_id` = 7, home_type = 6 ';   // Cosmetic Special set
        }
        
	foreach($arr_ordering as $ordering=>$psku_id) 
        {
            if((int)$psku_id > 0)
            {
                $query = 'UPDATE '.T_PRODUCT_SKU.' SET `ordering_home`='.(int)$ordering.', `home`=1 '.$addition.' WHERE `psku_id`='.(int)$psku_id.' LIMIT 1';
                //echo $query; echo '<br />';
                if (!($result = $ObjDB->sql_query($query))) {message_die(GENERAL_ERROR, 'Couldnot query hot promotion information', '', __LINE__, __FILE__, $query);}
            }		
	}
	
}

function update_ordering_news_home($arr_ordering=array()) {
global $ObjDB;
        
	foreach($arr_ordering as $ordering=>$news_id) {
		$query = 'UPDATE '.T_NEWS_ECOM.' SET `ordering_home`='.(int)$ordering.' WHERE `news_id`='.(int)$news_id.' LIMIT 1';
                if((int)$news_id>0)
                        $ObjDB->sql_query($query);
	}

}

function chk_Code($order_id=0){
	global $ObjDB;

	$query = 'SELECT o.delivery_code ';
	$query.= 'FROM '.T_ORDER.' AS o  ';
	$query.= 'WHERE (o.order_id='.(int)$order_id.') ';
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query count hightlignt news information", "", __LINE__, __FILE__, $query);}
	$data = $ObjDB->sql_fetchrow($result);
	$val = $data['delivery_code'];
	return $val;

}

function generate_coupon_code($total=0, $length=0, $prefix='', $format='') {
	global $ObjDB;
	
	$coupon = array();

	$char = 'ABCDEFGHKMNPQRSTUVWXYZ';
	$number = '0123456789';
	switch($format) {
		case 'number': $chars = $number; break;
		case 'alphabet': $chars = $char; break;
		default: $chars = $char.$number;
	}

	srand((double)microtime()*1000000);
	if (empty($prefix)) {
	} else {
	}

	$amount = $total;
	$code_buffer = $amount * 10 /100;
	$amount+= $code_buffer;


	for($i=0; $i<$amount; $i++) {
		$j = 0; $word = '' ;

		while(strlen($word) < $length) {
			$num = rand(0, strlen($chars)) % 33;
			$tmp = substr($chars, $num, 1);
			$word.= $tmp;
		}

		$coupon[] = $prefix.$word;
	}
	sort($coupon);

	if (!empty($coupon)) {
		$arr_sql = array();
		foreach($coupon as $item) {
			$arr_sql[] = 'SELECT \''.$item.'\' AS `code`';
		}
		$coupon = array();
		$query = 'SELECT DISTINCT `a`.`code` ';
		$query.= 'FROM (';
		$query.= implode(' UNION ', $arr_sql);
		$query.= ') AS `a` ';
		$query.= 'WHERE (`a`.`code` NOT IN (SELECT `coupon_code` FROM '.T_COUPON.')) ';
		$query.= 'ORDER BY `a`.`code` ';
		$query.= 'LIMIT '.(int)$total;
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, "Couldn't query count hightlignt news information", "", __LINE__, __FILE__, $query);}
		while($data = $ObjDB->sql_fetchrow($result)) {
			$coupon[] = $data['code'];
		}
	}

	return $coupon;
}

function get_cat($id=0,$ln='th'){
	global $clsSession, $ObjDB;
	$query = 'SELECT pcat_title_th,pcat_title_en FROM '.T_PRODUCT_CAT;
	$query.= ' WHERE pcat_status=1 AND pcat_id='.$id;

	if($id){
		if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query Product category', '', __LINE__, __FILE__, $query); }
		if($result){
			$data= $ObjDB->sql_fetchrow($result);
			$title['th']=$data['pcat_title_th'];
			$title['en']=$data['pcat_title_en'];
		}
	}
	return $title[$ln] ? $title[$ln]:'';
}

function get_type($id=0,$ln='th'){
	global $clsSession, $ObjDB;

	$query = 'SELECT ptype_title_th, ptype_title_en FROM '.T_PRODUCT_TYPE;
	$query.= ' WHERE ptype_status=1 AND ptype_id='.$id;

	if($id){
		if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query Product type', '', __LINE__, __FILE__, $query); }
		if($result){
			$data= $ObjDB->sql_fetchrow($result);
			$title['th']=$data['ptype_title_th'];
			$title['en']=$data['ptype_title_en'];
		}
	}
	return $title[$ln] ? $title[$ln]:'';
}

function check_autoresize($filename='',$w,$h,$fit=true){
	if(!$filename) return false;
	list($img_width, $img_height, $img_type, $img_attr)= getimagesize($_FILES[$filename]['tmp_name']);
	if($img_width > $w OR $img_height > $h){
		if($fit)$options['Fit_Image']=true;
		$options['Image_Width']=$w;
		$options['Image_Height']=$h;
	}
	return $options;
}

function uploadImage2($desFolder='.',$options=array()) {
global $ObjDB;
	IO::createFolder($desFolder);

	//Upload Image
	require_once(_MODULE . '/uploadfile.class.php');
	require_once(_MODULE . '/thumbnail.class.php');
	$objUpload = new httpUpload();
	$objUpload->FieldFileName = ( !empty($options['FieldFileName']) ? $options['FieldFileName'] : 'Image');
	$objUpload->AllowedTypes = ( !empty($options['AllowedExtension']) ? $options['AllowedExtension'] : array('jpg', 'jpeg', 'gif', 'png') );
	$objUpload->DestPath = $desFolder .'/';
	$objUpload->SaveToFolder = true;
	$objUpload->UniqueFromClientFileName = ( !empty($options['UniqueFromClientFileName']) ? $options['UniqueFromClientFileName'] : false);
	$objUpload->UniqueFileName = ( !empty($options['UniqueFileName']) ? $options['UniqueFileName'] : false);
	$objUpload->UploadFiles = 1;

	if ( !empty($options['MaxFileSize']) ) $objUpload->MaxFileSize = $options['MaxFileSize'];
	$objUpload->ProceedUpload();

	if( $objUpload->log['filename'][0] != '' ) {
		
		//----------
		$objThumb = new stdClass;
		// Resize Original Image
		if ( (int)$options['Image_Width'] > 0 && (int)$options['Image_Height'] > 0 ) {
			$objThumb = new Thumbnail( $objUpload->log['fullpath'][0] );

			$objThumb->resize_original_image( (int)$options['Image_Width'], (int)$options['Image_Height'], ((bool)$options['Fit_Image'] ? true : false) );

			list($width, $height, $type, $attr) = getimagesize( $objUpload->log['fullpath'][0] );
			$objUpload->log['image_width'][0] = $width;
			$objUpload->log['image_height'][0] = $height;

			$objThumb->destruct(); // Clear Resource
		}
		$objThumb->img = array('thumb_name'=> $objUpload->log['filename'][0], 'thumb_width'=> $objUpload->log['image_width'][0], 'thumb_height'=> $objUpload->log['image_height'][0]);
		//----------
		return $objUpload->FileName;
	} else {
		return $objUpload->log['status'];
	}
	//return end($objUpload->log['status']);
}

function myprint($data, $data2){
	echo '<pre>'; 
        if(($data!='')) 
            print_r($data);
	if(!empty($data2)) 
            echo print_r($data2); 
        exit;
}

function export_excel(){

	/** Include PHPExcel */
	require_once './module/excel_2007/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	 ->setLastModifiedBy("Maarten Balliauw")
	 ->setTitle("Office 2007 XLSX Test Document")
	 ->setSubject("Office 2007 XLSX Test Document")
	 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	 ->setKeywords("office 2007 openxml php")
	 ->setCategory("Test result file");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Hello')
	->setCellValue('B2', 'world!')
	->setCellValue('C1', 'Hello')
	->setCellValue('D2', 'world!');

	// Miscellaneous glyphs, UTF-8
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A4', 'Miscellaneous glyphs')
	->setCellValue('A5', '?????????????????');

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Simple');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="01simple.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');


}

function get_specialset_data_order_compo($specialset_id=0,$inorder=0){
    global $ObjDB;
    if( $inorder &&  $specialset_id){
        $sql = 'SELECT `op`.* , (`op`.`price` *  `op`.`value`) AS  `total_price`,SUM(`op`.`value`) AS `t_value` ';
        $sql .= ' FROM  '.T_PRODUCT_ORDER.' AS  `op` ';
        $sql .= ' LEFT JOIN  '.T_ORDER.' AS  `o` ON (`o`.`order_id` = `op`.`order_id`) ';
        $sql .= ' WHERE  `op`.`psku_id` = '.$specialset_id;
        $sql .= ' AND `op`.`component_id` !=  0 AND `op`.`order_id` = '.$inorder;
        $sql .= ' GROUP BY `op`.`psku_id`,`op`.`price`';
        if ( !($result = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not query product speical set component information', '', __LINE__, __FILE__, $sql);}
        $data = $ObjDB->sql_fetchrowset($result);

    }
    return $data;
}

function get_specialset_data($specialset_id=0,$number=0,$price=0){
    global $ObjDB;
    if( $specialset_id && $number && $price){
        $sql = 'SELECT `sp`.`product_id`,`sp`.`product_code`,`sp`.`quantity`';
        $sql .= ' ,(select `product_title_th` from '.T_PRODUCT_ORDER.' where `component_id`=`sp`.`product_id` LIMIT 1) AS `product_name_th` ';
        $sql .= ' ,(select `price` from '.T_PRODUCT_ORDER.' where `component_id`=`sp`.`product_id` LIMIT 1) AS `price` ';
        $sql .= ' FROM  '.T_PRODUCT_SPECIALSET.' AS  `sp` ';
        $sql .= ' WHERE  `sp`.`special_set_id` = '.$specialset_id;
        $sql .= ' GROUP BY `sp`.`product_code`';
        if ( !($result = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not query product speical set component information', '', __LINE__, __FILE__, $sql);}
        $data = $ObjDB->sql_fetchrowset($result);
        
        foreach($data AS $index => $arrdata){
            $data[$index]['t_value'] = (int)$arrdata['quantity'] * (int)$number;
            $data[$index]['t_price'] = (int)$arrdata['price'] * (int)$data[$index]['t_value'];
        }
    }
    return $data;
}

function get_group_order($groupset_id=0){
     global $ObjDB;
     if($groupset_id!=0){
         $query = 'SELECT `order_id`,order_code FROM '.T_ORDER.' WHERE `shipping_group_id` = '.$groupset_id;
         if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrowset($result);
     }
     return $data;
}

function delectgroupdata($group_id=0){
    global $ObjDB;
    if($group_id!=0){
        $query = 'DELETE FROM '.T_ORDER_SHIP.' WHERE `order_ship_id` = '.$group_id;
         if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    }
    return $result;
}

function get_degit_number($tracking_number){
$tracking_number = sprintf("%06d",$tracking_number);
	$tracking_number = LION_CODE.$tracking_number;
	$multi_number = 86423597;
	$count = strlen($tracking_number);
	$arr = array(); $arr_multi = array(); $multi_value = array();

	if($count == 8){
		for ($i=0; $i < $count; $i++){
			$arr[] = substr($tracking_number, $i , 1);
			$arr_multi[] = substr($multi_number, $i , 1);
			$multi_value[] = $arr[$i] * $arr_multi[$i];
			$summary_value += $multi_value[$i];
		}
                
	}

	$mod = ($summary_value%11);

	if ( $mod == 1 ){ $digit_num = 0; }
	else if ( $mod == 0 ){ $digit_num = 5; }
	else if ($mod != 0 || $mod != 1){ $digit_num = (11 - $mod); }

	return (int)$digit_num;
}

function getcoupon($coupon_id=0,$coupon_code=''){
    global $ObjDB;
    if($coupon_code!=''){
        $query = 'select * FROM '.T_COUPON.' WHERE `order_limit` > `order_used` AND CURDATE() BETWEEN `date_active` AND `date_expired` AND `coupon_code` = \''.$coupon_code.'\'' ;
    }
    if($coupon_id!=0){
        $query = 'select * FROM '.T_COUPON.' WHERE `order_limit` > `order_used` AND CURDATE() BETWEEN `date_active` AND `date_expired` AND `coupon_id` = '.$coupon_id;
    }
    if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrow($result);
    return $data;
}

function insert_component_set($component=array(),$setvalue=0,$orderid=0){
    global $ObjDB , $clsSession;
    if(!empty($component)){

    foreach($component as $comData) {
	$values = array();
	$values['psku_id'] = (int)$comData['special_set_id'];
	$values['component_id'] = (int)$comData['product_id'];
	$values['product_code'] = encode_to_db($comData['product_code']);
	$values['product_title_th'] = encode_to_db($comData['title_th']);
	$values['product_title_en'] = encode_to_db($comData['title_en']);
	$values['product_description_th'] = encode_to_db($comData['detail_th']);
	$values['product_description_en'] = encode_to_db($comData['detail_en']);
	$values['unit_th'] = encode_to_db($comData['unit_th']);
	$values['unit_en'] = encode_to_db($comData['unit_en']);
	$values['order_id'] = (int)$orderid;
	$values['value'] = (int)$comData['quantity'] * (int)$setvalue;
	$values['price'] = (int)$comData['price'];
	$query = $ObjDB->sql_build('INSERT', T_PRODUCT_ORDER, $values);
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create products order information', '', __LINE__, __FILE__, $query);}
	// UPDATE STOCK
							
        $query = 'UPDATE '.T_PRODUCT_SKU.' SET `amount`=`amount`-'.((int)$comData['quantity'] * (int)$setvalue).', `sale_out`=`sale_out`+'.(int)$comData['quantity'] * (int)$setvalue.' WHERE (`psku_id`='.(int)$comData['product_id'].')';
	$ObjDB->sql_query($query);

	// CREATE LOG STOCK
	create_LogStock($comData['psku_id'], ((int)$comData['quantity'] * (int)$setvalue), 'order', $clsSession->get_auth('member_id'));
							
	}
      $result = true;
    }
    
    return $result;
}

function insert_psku($postpara=array(),$data=array()){
    global $ObjDB , $clsSession;
    if(!empty($postpara) && !empty($data)){
        
    $values =array();
                    $values['order_id']= $postpara['Id'];
                    $values['psku_id']= $postpara['psku_id'];
                    $values['product_code'] = $data['product_code'];
                    $values['product_title_th']= encode_to_db($data['product_name_th']);
                    $values['product_title_en']= encode_to_db($data['product_name_en']);
                    $values['product_description_th']= encode_to_db($data['description_th']);
                    $values['product_description_en']= encode_to_db($data['description_en']);
                    $values['unit_th']= $data['title_th'];
                    $values['unit_en']= $data['title_en'];
                    $values['value']= $postpara['quantity'];
                    $values['price']= $data['Price'];
                    $values['discount_price']= 0;
                    $query = $ObjDB->sql_build('INSERT', T_PRODUCT_ORDER, $values);
                    $result = $ObjDB->sql_query($query);
                    
                    $query = 'UPDATE '.T_PRODUCT_SKU.' SET `amount`=`amount`-'.(int)$postpara['quantity'].', `sale_out`=`sale_out`+'.((int)$postpara['quantity']).' WHERE (`psku_id`='.(int)$postpara['psku_id'].')';
                    $ObjDB->sql_query($query);
        
                    // CREATE LOG STOCK
                    create_LogStock($postpara['psku_id'], $postpara['quantity'], 'order', $clsSession->get_auth('member_id'));
      $result = true;
    }
    return $result;
}

function get_product_components($special_set_id=0) {
	global  $ObjDB, $clsSession;
	
	$data = array();
	$query = ' SELECT  `ps`.`special_set_id`, `ps`.`product_id`, `ps`.`product_code`, `ps`.`title_th`, `ps`.`title_en`, `ps`.`detail_th`, `ps`.`detail_en`, `ps`.`quantity`, `ps`.`price` ';
	$query.= ' , `u`.`title_th` AS `unit_th`, `u`.`title_en` AS `unit_en` ';
	$query.= ' FROM '.T_PRODUCT_SPECIALSET.' AS `ps` ';
	$query.= ' LEFT JOIN '.T_UNIT.' AS `u` ON `u`.`unit_id` = `ps`.`unit_id` ';
	$query.= ' WHERE `special_set_id` = '.$special_set_id;
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not get product special set (component) information', '', __LINE__, __FILE__, $query);}
        if ($ObjDB->sql_numrows($result) > 0) {
            while($temp = $ObjDB->sql_fetchrow($result)){
                $data[] = $temp;
            }
        }
	return $data;
}

function get_product_components_full($special_set_id=0) {
	global  $ObjDB, $clsSession;
	
	$data = array();
	$query = ' SELECT b.*, `us`.`username` AS user_name ,`b`.`title_th`,(`b`.`amount`) AS `stock_balance_amount`,`d`.*,`a`.*,(`a`.`product_id`) AS `psku_id` 
            , (`a`.`detail_th`) AS `description_th` ,(`a`.`detail_en`) AS `description_en` 
            , (`u`.`title_th`) AS `unit_th` , (`u`.`title_en`) AS `unit_en`,`a`.`special_set_id` AS `main_set_id`
            ,IF((b.published=1 and (CURDATE() BETWEEN date(b.date_active) AND date(b.date_expired) )),1,0) AS flag_activate ';
	$query.= ' FROM '.T_PRODUCT_SPECIALSET.'AS `a`';
	$query.= ' LEFT JOIN '.T_PRODUCT_SKU.' AS `b` ON (`a`.`product_id`=`b`.`psku_id`) ';
	$query.= ' LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`b`.`psku_id`) ';
	$query.= ' LEFT JOIN '.T_UNIT.' AS `u` ON (`u`.`unit_id` = `b`.`unit_id`)
                    LEFT JOIN '.T_USER.' AS `us` ON  (`us`.`user_id` = `b`.`user_modify`) ';
	$query.= ' WHERE a.special_set_id = '.(int)$special_set_id.' group by b.psku_id ';
	$query.= ' ORDER BY `b`.`psku_id` ASC ';
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not get product special set (component) information', '', __LINE__, __FILE__, $query);}
        if ($ObjDB->sql_numrows($result) > 0) {
            while($data = $ObjDB->sql_fetchrow($result)){
                
                $data['image_url'] = BASEURL.'/images/default_image_1.gif';
                if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) {
                        $data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
                        $_arr = IO::autoImageSize($data['image_width'], $data['image_height'], 80, 60);
                        $data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
                } else {
                        $data['image_width'] = 80; $data['image_height'] = 60;
                }
                $data['order_quantity'] = ($data['quantity']*$qty);
                $data['total_order_value'] = ($data['order_quantity']*$data['price']);
                $data['title_th_sta'] = $data['title_th'].'<br />'.status_sku_text($data['psku_id']);
                $Content[] = $data;
            }
        }
        
	return $Content;
}

function get_product_componentsV2($special_set_id=0,$value=0) {
    global  $ObjDB, $clsSession;    
    $data = array();
	$query = ' SELECT  `ps`.`special_set_id`, `ps`.`product_id`, `ps`.`product_code`, `ps`.`title_th`, `ps`.`title_en`, `ps`.`detail_th`, `ps`.`detail_en`, `ps`.`quantity`, `ps`.`price` ';
	$query.= ' , `u`.`title_th` AS `unit_th`, `u`.`title_en` AS `unit_en` ';
	$query.= ' FROM '.T_PRODUCT_SPECIALSET.' AS `ps` ';
	$query.= ' LEFT JOIN '.T_UNIT.' AS `u` ON `u`.`unit_id` = `ps`.`unit_id` ';
	$query.= ' WHERE `special_set_id` = '.$special_set_id;
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not get product special set (component) information', '', __LINE__, __FILE__, $query);}
	if ($ObjDB->sql_numrows($result) > 0) 
        for($i=0;$i<$ObjDB->sql_numrows($result);$i++){
            $data[$i] = $ObjDB->sql_fetchrow($result);
            if($value!=0) $data[$i]['value'] = $value * $data[$i]['quantity'];
        }

	return $data;
}

function update_product($sku_id=0,$quantity=0,$mode=1,$orderid=0,$action='+',$update='ALL'){
// mode 1 = normal product || mode 2 = set mode compo
//action + = normal action ซื้อ จำนวนเพิ่มจากเดิม if action '-' คือคืนสินค้าหรือ ไม่ก็ จำนวนลดลง
    global $ObjDB , $clsSession;
    if($action=='+'){
        $mark1 = '+';       $mark2 = '-';   }
    else{
        $mark1 = '-';       $mark2 = '+';   }
    
    $modename = '`psku_id`';
    if($mode == 2) $modename = '`component_id`';
    else $component = ' AND `component_id` = 0 ';
    
    
    if($sku_id != 0 && $quantity != 0 && $orderid != 0){
                        $query = 'update '.T_PRODUCT_ORDER;
                        $query .= ' set `value` = `value` '.$mark1.($quantity);
                        $query .= ' where '.$modename.' = '.$sku_id;
                        $query .= ' AND `order_id` = '.$orderid;
                        $query .= $component;
                        if($update=='ALL') $result = $ObjDB->sql_query($query);
                        
                        $query = ' update '.T_PRODUCT_SKU.' set amount = amount '.$mark2.($quantity);
                        $query .= ' ,`sale_out` = `sale_out` '.$mark1.($quantity);
                        $query .= ' where `psku_id` = '.$sku_id;
                        $ObjDB->sql_query($query);
                        
                        // CREATE LOG STOCK
                    create_LogStock($sku_id, $quantity, 'order', $clsSession->get_auth('member_id'));

    }
}

function remove_status_coupon($orderid=0){
    global $ObjDB , $clsSession;
    $action = false;
    
    if($orderid!=0){
        $query = 'select * from '.T_ORDER_COUPON.' where `order_id` = '.$orderid;
        $result = $ObjDB->sql_query($query);
        $coupon = $ObjDB->sql_fetchrow($result);
        
        if(!empty($coupon)){
            
        $query = 'select * from '.T_COUPON.' AS `cou`';
        $query .= ' left join '.T_ORDER_COUPON.' AS `oc` ON `oc`.`coupon_id` = `cou`.`coupon_id`';
        $query .= ' where `oc`.`coupon_code` = \''.$coupon['coupon_code'].'\'';
        $query .= ' AND `oc`.`order_id` = '.$orderid;
        $result = $ObjDB->sql_query($query);
        $data = $ObjDB->sql_fetchrow($result);
        
        if(!empty($data)){
            $query = 'delete from '.T_ORDER_COUPON.' where `coupon_code` = \''.$coupon['coupon_code'].'\'';
            $query .= ' AND `order_id` = '.$orderid;
            if($ObjDB->sql_query($query))
                create_log_coupon($orderid,$coupon['coupon_code'],'Remove');
            
            
            //resume status to coupon
            $query = 'update '.T_COUPON.' SET `order_used` = `order_used` - 1 where `coupon_code` = \''.$coupon['coupon_code'].'\'';
            $result = $ObjDB->sql_query($query);
            
            $query = 'update '.T_ORDER.' SET `total_discount` = `total_discount` - '.$coupon['discount_price'].' where `order_id` = '.$orderid; 
            $result = $ObjDB->sql_query($query);
            $action = true;
            }
        }
    }
    return $action;
}

function refresh_Update_cart($psku=array(),$order=0){
    global $ObjDB , $clsSession;
    
    if(!empty($psku) && $order!=0){
        $query = 'select * from '.T_PRODUCT_ORDER.' where order_id = '.$order.' and component_id = 0';
        $result = $ObjDB->sql_query($query);
        $orderdata = $ObjDB->sql_fetchrowset($result);
        
        foreach($orderdata AS $index => $orderdetail){
            $sku_id = $orderdetail['psku_id'];
            $order_sku[$sku_id] = $orderdetail['value'];
        }
              
        foreach($order_sku AS $skuid => $value){
            $action = '';
            if($psku[$skuid]!=0){
                $diffvalue = ($psku[$skuid] - $value);
                if($diffvalue > 0) $action = '+';

                if($diffvalue < 0) $action = '-';

                if( $diffvalue == 0){}

                $IsThisSET = is_sku_SET($skuid);
                $diffvalue = abs($diffvalue);
                
                if($action!=''){
                    update_product($skuid,$diffvalue,1,$order,$action);
                    if((bool)$IsThisSET){
                            $comdata = get_product_components($skuid);
                            foreach($comdata AS $index => $comdataarr){
                                $diffnumber = $comdataarr['quantity'] * $diffvalue; 
                                update_product($comdataarr['product_id'],$diffnumber,2,$order,$action);
                            }
                    }
                }    
                    
            }
        }
        
        refresh_table_order($order);
    }
    
    return true;
}

function is_sku_SET($sku_id=0){
    global $ObjDB , $clsSession;
    if($sku_id!=0){
        $query = 'select * from '.T_PRODUCT_SKU.' where `psku_id` = '.$sku_id;
        $result = $ObjDB->sql_query($query);
        $data = $ObjDB->sql_fetchrow($result);
        
        $results = ($data['pcat_id']==7 && $data['type']==3)? true : false;
    }
    return $results;
}

function refresh_table_order($orderid = 0,$getspecial = true){
    global $ObjDB , $clsSession;

    if($orderid!=0){
        $update_result = false;
        $query = 'select * from '.T_PRODUCT_ORDER.' where `order_id` = '.$orderid.' and `component_id` = 0';
        $result = $ObjDB->sql_query($query);
        $data = $ObjDB->sql_fetchrowset($result);

        if( $data ){
            $total_price = $total_amount = 0;
            foreach($data AS $index => $arrdata){
                $total_amount += $arrdata['value'];
                $total_price += ($arrdata['value'] * $arrdata['price']);
                
            }
        
        $giftvalue = 0;
        $values = array();
            if( $getspecial ){
                $gbl_common = new global_common;
		$promotion = $gbl_common->get_promotion_description();
                //SET PROMOTION FOR ORDER
			if (!empty($promotion)) {
                                $values = $gbl_common->build_promotion_data($promotion);
                                $values['promotion_value'] = floor($promotion['total_price_promotion'] / (int)$promotion['limit']);
			}
                        if($values['promotion_value']<=0){
                            $values = array();
                        }
            }
            if($total_price>get_gold_rate()){
                $tmp = function_get_point_cal($total_price);
                $values['gold_coin'] = $tmp['gold_coin'];
                $values['gold_rate'] = $tmp['gold_rate'];
            }
            $tmp = get_shipping_rate_b($total_price);
            $shipping_rate = $tmp['value'];
            if($total_price < $tmp['condition']){
                $total_price += $shipping_rate;
                
                $values['shipping_rate_id'] = $tmp['shipping_id'];
                $values['shipping_rate_title'] = $tmp['title_code'];
            }
            else $shipping_rate = 0.00;
            
        //update amount data
        $values['total_amount'] = $total_amount;
        $values['total'] = $total_price;
        $values['shipping'] = $shipping_rate;
        $query = $ObjDB->sql_build('UPDATE', T_ORDER, $values, '`order_id` = '.$orderid, 1 );
        if($ObjDB->sql_query($query)) {$update_result = true;}
        
        //update coupon data
        $query = 'select * from '.T_ORDER_COUPON.' where `order_id` = '.$orderid;
        $result = $ObjDB->sql_query($query);
        $data = $ObjDB->sql_fetchrow($result);
        
        if(!empty($data)){
            $query = 'update '.T_ORDER.' SET `total_discount` = '.$data['discount_price'].' where `order_id` = '.$orderid.' limit 1';
           
            $ObjDB->sql_query($query);
            }
        }
    }
    return $update_result;
}

function check_order_product_data($postpara){
    global $ObjDB;
          $query = 'select * from '.T_PRODUCT_ORDER.' WHERE `psku_id` = '.$postpara['psku_id'];
                $query .= ' AND `order_id` = '.$postpara['Id'];
                $result = $ObjDB->sql_query($query);
                $data = $ObjDB->sql_fetchrow($result);
    return $data;
}

function get_Promotion_back($total=0){
	global  $ObjDB,$clsSession;
if($total>0){
        $promotion = array('active'=>false);
        
        $Condition = array();
	$Condition[] = '(`date_active` <= CURDATE() AND `date_expired` >= CURDATE() )';
        $Condition[] = '`published`=1';
	
	$strCond = implode(' AND ', $Condition);
        
        $query = 'select * from '.T_PROMOTION.' where '.$strCond.' order by `limit` asc';
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query promotion information', '', __LINE__, __FILE__, $query);}
        $promotiondata = $ObjDB->sql_fetchrowset($result);
        
        foreach($promotiondata AS $index => $prodataarr){
            if($total>=$prodataarr['limit']){
                $proid = $prodataarr['promotion_id'];
                $prolimit = $prodataarr['limit'];
                }
        }
        $value = floor($total/$prolimit);

	$query = 'SELECT * FROM '.T_PROMOTION.' WHERE promotion_id = '.$proid.' ORDER BY `date_active` DESC LIMIT 1';

if(!empty($proid)){
	if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query promotion information', '', __LINE__, __FILE__, $query);}
        }
	if ($ObjDB->sql_numrows($result) !=0) {
		$data = $ObjDB->sql_fetchrow($result);
		$data['detail'] = $clsSession->getLangText($data['detail_th'], $data['detail_en']);
		$data['remark'] = $clsSession->getLangText($data['remark_th'], $data['remark_en']);

		$promotion['active'] = true;
		$promotion['promotion_id'] = $data['promotion_id'];
		$promotion['title'] = $clsSession->display_text($data['title_th'], $data['title_en']);
		$promotion['detail'] = $clsSession->display_text($data['detail_th'], $data['detail_en']);
		$promotion['remark'] = $clsSession->display_text($data['remark_th'], $data['remark_en']);
		$promotion['limit'] = $data['limit'];
		$promotion['premium'] = $data['premium'];
		$promotion['title_th'] = $data['title_th'];
		$promotion['title_en'] = $data['title_en'];
		$promotion['detail_th'] = $data['detail_th'];
		$promotion['detail_en'] = $data['detail_en'];
                $promotion['value'] = $value;
	}
    }
	return $promotion;
}

function getuser($orderid = 0){
    global  $ObjDB,$clsSession;
    if($orderid>0){
        $query = 'select `member_id`,`location_delivery` from '.T_ORDER.' where `order_id` = '.$orderid;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrow($result);
        
        $query = 'select *,CONCAT(`member_fname`,"  ",`member_lname`) AS `fullname` from '.T_MEMBER.' where `member_id` = '.$data['member_id'];
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $memberdata = $ObjDB->sql_fetchrow($result);
        
    $date = date("d-m-Y",strtotime($memberdata['member_birthday']));
    $date = (explode('-',$date));
    $date[2] = (int)$date[2] + 543;
    $memberdata['member_birthday'] = $date = implode('-',$date);
    
    //shipping address And order address
    $query = 'select * from '.T_ORDER_ADDRESS;
    $query .= ' where `order_id` = '.$orderid;
    $query .= ' order by `order_id` DESC limit 1';
    if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    $shipdata = $ObjDB->sql_fetchrow($result);
    if( !empty($shipdata) )
			$memberdata['has_address'] = 1;
			$memberdata['shippingAdd'] = $shipdata;
			$memberdata['location_delivery'] = $data['location_delivery'];
    }
    return $memberdata;
}

function search_foruser($condition = ''){
    global  $ObjDB,$clsSession;
    $query = 'select *,CONCAT(`member_fname`,"  ",`member_lname`) AS `fullname` from '.T_MEMBER;
    if($condition!='')  $query .= ' where '.$condition;

        $result = $ObjDB->sql_query($query);
        $memberdata = $ObjDB->sql_fetchrowset($result);
    return $memberdata;
}

function create_log_order($orderid=0,$newmemberid=0,$mark=''){
    global  $ObjDB,$clsSession;
    $response = 0;
    if($orderid!=0 && $newmemberid!=0){
        $query = 'select * from'.T_ORDER.' where `order_id` = '.$orderid;
        $result = $ObjDB->sql_query($query);
        $orderdata = $ObjDB->sql_fetchrow($result);
        if(!empty($orderdata)){
            if($mark=='') $mark = 'change order member to a new member';
            $values = array();
            $values['change_date'] = 'NOW()';
            $values['new_member_id'] = (int)$newmemberid;
            $values['mod_user_id'] = (int)$clsSession->get_auth('Id');
            $values['remark'] = $mark;
            $values['old_member_id'] = (int)$orderdata['member_id'];
            $values['order_id'] = (int)$orderid;
            
            $query = $ObjDB->sql_build('INSERT', T_LOG_ORDER, $values);
            if($ObjDB->sql_query($query))
                $response = 1;
        }
    }
    return $response;
}

function get_amount_use_for_check_limit($sku_id=0,$value=0){
    global  $ObjDB;
    if($sku_id!=0){
            $query = 'select *,IF(CURDATE() BETWEEN `promotion_date_active` AND `promotion_date_expired`,sale,price) AS `nowprice`';
            $query .= ' ,`sku`.`title_th` AS `product_name_th`';
            $query .= ' ,`sku`.`title_en` AS `product_name_en`';
            $query .= ' from '.T_PRODUCT_SKU.' AS `sku`';
            $query .= ' left join '.T_UNIT.' AS `unit` ON `unit`.`unit_id` = `sku`.`unit_id`';
            $query .= ' where `psku_id` = '.$sku_id;
            $result = $ObjDB->sql_query($query);
            $skudata = $ObjDB->sql_fetchrow($result);
            if($value!=0) $skudata['discount'] = ($value * $skudata['price'])-($value * $skudata['nowprice']);
    }
    return $skudata;
}

function getcart($cart=array()){
    global  $ObjDB;
    $product = array();
    $num = 0;
    $shipping_minimun_rate = 800;
    if(!empty($cart)){
        foreach($cart AS $skuid => $value){
            
            $skudata = get_amount_use_for_check_limit($skuid,$value);
            $skudata['value'] = $value;
            $isset = is_sku_SET($skuid);
            
            $product[$num] = $skudata;
                if(!$isset){
                    $overlimit = ($skudata['amount']<$value? 1 : 0);
                    $product['total'] += $skudata['nowprice']*$value;
                    $product['total_amount'] += $value;
                }
                else{
                    $overlimit = ($skudata['amount']<$value? 1 : 0);
                    $component = array();
                    $component = get_product_componentsV2($skuid,$value);
                    $product[$num]['components'] = $component;
                    $product['total_amount'] += $value;
                    $product['total'] += $skudata['nowprice']*$value;
                    
                    if(!empty($component)){
                        foreach($component AS $index => $comarrdata){
                            $skucomdata = get_amount_use_for_check_limit($comarrdata['product_id']);
                            $overlimit = ($skucomdata['amount']<$comarrdata['value']? 1 : 0);
                        }
                    }
                }
                ++$num;
        }
        $product['overlimit'] = $overlimit;
        $product['shipping'] = ($product['total']>$shipping_minimun_rate? 0 : 50);
        $product['total'] += $product['shipping'];
        //$product['status'] = 8;

        return $product;
        
    }
}

function insert_product_order($cart=array(),$orderid=0){
    global  $ObjDB;
    if(!empty($cart) && $orderid != 0){

        foreach($cart AS $index => $arrdata){
            $values = array();
            if(is_numeric($index)){
                $specialsetid = (int)$arrdata['psku_id'];
                $values['order_id'] = (int)$orderid;
                $values['psku_id'] = (int)$arrdata['psku_id'];
                $values['component_id'] = 0;
                $values['product_code'] = encode_to_db($arrdata['product_code']);
                $values['product_title_th'] = encode_to_db($arrdata['product_name_th']);
                $values['product_title_en'] = encode_to_db($arrdata['product_name_en']);
                $values['product_description_th'] = encode_to_db($arrdata['description_th']);
                $values['product_description_en'] = encode_to_db($arrdata['description_en']);
                $values['unit_th'] = encode_to_db($arrdata['title_th']);
                $values['unit_en'] = encode_to_db($arrdata['title_en']);
                $values['value'] = (int)$arrdata['value'];
                $values['price'] = (int)$arrdata['nowprice'];
                $values['discount_price'] = (int)$arrdata['discount'];
                $query = $ObjDB->sql_build('INSERT', T_PRODUCT_ORDER, $values);
                
                if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                else
                    update_product_for_order($arrdata['psku_id'],$arrdata['value'],1,$orderid,'+');
            
            if(!empty($arrdata['components'])){
                foreach($arrdata['components'] AS $index => $comdata){
                    $values = array();
                    $values['order_id'] = (int)$orderid;
                    $values['psku_id'] = (int)$specialsetid;
                    $values['component_id'] = (int)$comdata['product_id'];
                    $values['product_code'] = encode_to_db($comdata['product_code']);
                    $values['product_title_th'] = encode_to_db($comdata['title_th']);
                    $values['product_title_en'] = encode_to_db($comdata['title_en']);
                    $values['product_description_th'] = encode_to_db($comdata['detail_th']);
                    $values['product_description_en'] = encode_to_db($comdata['detail_en']);
                    $values['unit_th'] = encode_to_db($comdata['unit_th']);
                    $values['unit_en'] = encode_to_db($comdata['unit_en']);
                    $values['value'] = (int)$comdata['value'];
                    $values['price'] = (int)$comdata['price'];
                    $values['discount_price'] = 0;
                    $query = $ObjDB->sql_build('INSERT', T_PRODUCT_ORDER, $values);
                    
                    if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                    else
                        update_product_for_order($values['component_id'],$comdata['value'],2,$orderid,'+');
                    }
                }
            }
        }
    }
}

function update_product_for_order($sku_id=0,$quantity=0,$mode=1,$orderid=0,$action='+'){
// mode 1 = normal product || mode 2 = set mode compo
//action + = normal action ซื้อ จำนวนเพิ่มจากเดิม if action '-' คือคืนสินค้าหรือ ไม่ก็ จำนวนลดลง
    global $ObjDB , $clsSession;
    if($action=='+'){
        $mark1 = '+';       $mark2 = '-';   }
    else{
        $mark1 = '-';       $mark2 = '+';   }
    
    $modename = '`psku_id`';
    if($mode == 2) $modename = '`component_id`';
    else $component = ' AND `component_id` = 0 ';
    
    if($sku_id != 0 && $quantity != 0 && $orderid != 0){
                                                
                        $query = ' update '.T_PRODUCT_SKU.' set amount = amount '.$mark2.($quantity);
                        $query .= ' ,`sale_out` = `sale_out` '.$mark1.($quantity);
                        $query .= ' where `psku_id` = '.$sku_id;
                        if ( !($result = $ObjDB->sql_query($query)) ) {
                                message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                        
                        // CREATE LOG STOCK
                    create_LogStock($sku_id, $quantity, 'order', $clsSession->get_auth('member_id'));

    }
}

function update_address($memberid=0,$orderid=0){
    global $ObjDB;
    
    if($memberid!=0 && $orderid!=0){
        $result = 0;
        $query = 'select * from '.T_MEMBER;
        $query .= ' where `member_id` = '.$memberid;
        
        if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $data = $ObjDB->sql_fetchrow($result);

        if(!empty($data)){
            $values = array();
                                $values['order_id'] = (int)$orderid;
				$values['shipping_fname'] = encode_to_db($data['member_fname']);
				$values['shipping_lname'] = encode_to_db($data['member_lname']);
				$values['shipping_address'] = encode_to_db($data['member_address']);
				$values['shipping_moo'] = encode_to_db($data['member_moo']);
				$values['shipping_addr_type'] = encode_to_db($data['member_addr_type']);
				$values['shipping_soi'] = encode_to_db($data['member_soi']);
				$values['shipping_road'] = encode_to_db($data['member_road']);
				$values['shipping_tambon'] = encode_to_db($data['member_tambon']);
				$values['shipping_aumphur'] = encode_to_db($data['member_aumphur']);
				$values['shipping_province'] = encode_to_db($data['member_province']);
				$values['shipping_postcode'] = encode_to_db($data['member_postcode']);
				$values['shipping_phone'] = encode_to_db($data['member_phone']);
				$values['shipping_mobile'] = encode_to_db($data['member_mobile']);

				$values['porder_fname'] = encode_to_db($data['member_fname']);
				$values['porder_lname'] = encode_to_db($data['member_lname']);
				$values['porder_address'] = encode_to_db($data['member_address']);
				$values['porder_moo'] = encode_to_db($data['member_moo']);
				$values['porder_addr_type'] = encode_to_db($data['member_addr_type']);
				$values['porder_soi'] = encode_to_db($data['member_soi']);
				$values['porder_road'] = encode_to_db($data['member_road']);
				$values['porder_tambon'] = encode_to_db($data['member_tambon']);
				$values['porder_aumphur'] = encode_to_db($data['member_aumphur']);
				$values['porder_province'] = encode_to_db($data['member_province']);
				$values['porder_postcode'] = encode_to_db($data['member_postcode']);
				$values['porder_phone'] = encode_to_db($data['member_phone']);
				$values['porder_mobile'] = encode_to_db($data['member_mobile']);
            $query = $ObjDB->sql_build('UPDATE', T_ORDER_ADDRESS, $values,'order_id = '.(int)$orderid);
            if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                    else
                        $result = 1;
        }

    }
    return $result;
}

function update_address_arr($addressdata=array(),$orderid=0){
    global $ObjDB;
    
    if(!empty($addressdata) && $orderid!=0){

        if(!empty($addressdata)){
            $values = array();
            $values['order_id'] = (int)$orderid;
            $values['shipping_fname'] = encode_to_db(decode_from_db($addressdata['shipping_fname']));
            $values['shipping_lname'] = encode_to_db(decode_from_db($addressdata['shipping_lname']));
            $values['shipping_address'] = encode_to_db(decode_from_db($addressdata['shipping_address']));
            $values['shipping_moo'] = encode_to_db(decode_from_db($addressdata['shipping_moo']));
            $values['shipping_addr_type'] = encode_to_db(decode_from_db($addressdata['shipping_addr_type']));
            $values['shipping_soi'] = encode_to_db(decode_from_db($addressdata['shipping_soi']));
            $values['shipping_road'] = encode_to_db(decode_from_db($addressdata['shipping_road']));
            $values['shipping_tambon'] = encode_to_db(decode_from_db($addressdata['shipping_tambon']));
            $values['shipping_aumphur'] = encode_to_db(decode_from_db($addressdata['shipping_aumphur']));
            $values['shipping_province'] = encode_to_db(decode_from_db($addressdata['shipping_province']));
            $values['shipping_postcode'] = encode_to_db(decode_from_db($addressdata['shipping_postcode']));
            $values['shipping_phone'] = encode_to_db(decode_from_db($addressdata['shipping_phone']));
            $values['shipping_mobile'] = encode_to_db(decode_from_db($addressdata['shipping_mobile']));

            $values['porder_fname'] = encode_to_db(decode_from_db($addressdata['porder_fname']));
            $values['porder_lname'] = encode_to_db(decode_from_db($addressdata['porder_lname']));
            $values['porder_address'] = encode_to_db(decode_from_db($addressdata['porder_address']));
            $values['porder_moo'] = encode_to_db(decode_from_db($addressdata['porder_moo']));
            $values['porder_addr_type'] = encode_to_db(decode_from_db($addressdata['porder_addr_type']));
            $values['porder_soi'] = encode_to_db(decode_from_db($addressdata['porder_soi']));
            $values['porder_road'] = encode_to_db(decode_from_db($addressdata['porder_road']));
            $values['porder_tambon'] = encode_to_db(decode_from_db($addressdata['porder_tambon']));
            $values['porder_aumphur'] = encode_to_db(decode_from_db($addressdata['porder_aumphur']));
            $values['porder_province'] = encode_to_db(decode_from_db($addressdata['porder_province']));
            $values['porder_postcode'] = encode_to_db(decode_from_db($addressdata['porder_postcode']));
            $values['porder_phone'] = encode_to_db(decode_from_db($addressdata['porder_phone']));
            $values['porder_mobile'] = encode_to_db(decode_from_db($addressdata['porder_mobile']));
            $query = $ObjDB->sql_build('UPDATE', T_ORDER_ADDRESS, $values,'order_id = '.(int)$orderid,1);
            if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                    else
                        $result = 1;
        }

    }
    return $result;
}

function get_shipping_code($group_id, $company){

	if ((int)$company > 0 && (int)$group_id > 0 ){

		if ($company == 1) $strCode = 'TP';
		else if ($company == 2) $strCode = 'IE';
                else if ($company == 3) $strCode = 'LI';

		$group_code = $strCode.date("y").sprintf("%06d", (int)$group_id);
		return $group_code;
	}

}

function create_log_order_approve($order_id=0,$fromstep=0,$tostep=0,$action='',$remark=''){
    global $clsSession,$ObjDB;
    if($order_id!=0 && $fromstep!='' && $tostep!=''){
        $values = array();
        $values['order_id'] = (int)$order_id;
        $values['user_id'] = (int)$clsSession->get_auth('Id');
        $values['from_step'] = encode_to_db((int)$fromstep);
        $values['to_step'] = encode_to_db((int)$tostep);
        $values['action_description'] = encode_to_db($action);
        $values['remark'] = encode_to_db($remark);
        $values['action_date'] = 'NOW()';
        
        $query = $ObjDB->sql_build('INSERT', T_LOG_ORDER_APPROVE, $values);
        if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
    }
}

function create_log_coupon($orderid=0,$coupon_code='',$action=''){
    global $clsSession,$ObjDB;
    if($orderid!=0 && $coupon_code!=''){
        $values = array();
        $values['order_id'] = (int)$orderid;
        $values['action'] = encode_to_db($action);
        $values['coupon_code'] = encode_to_db($coupon_code);
        $values['member_id'] = (int)$clsSession->get_auth('Id');
        $values['create_date'] = 'NOW()';
        
        $query = $ObjDB->sql_build('INSERT', T_LOG_COUPON, $values);
        if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
    }
}

function create_new_order($memberid = 0){
    global $clsSession,$ObjDB;
    if($memberid!=0){
        $values = array();
                        $values['date_delivery'] = 'NOW()';
                        $values['delivery_code'] = get_delivery_code();
                        $values['date_purchase'] = 'NOW()';
                        $values['order_code'] = get_order_code(2);
			$values['payment_type'] = (int)2;
			$values['status'] = (int)8;
			$values['total'] = (int)0;
			$values['total_amount'] = (int)0;
			$values['total_discount'] = (int)0;
			$values['shipping'] = (int)0;
			$values['member_id'] = (int)$memberid;
                        $values['user_create'] = (int)$clsSession->get_auth('Id');
                        $values['special_case'] = (int)1;
			$values['lang'] = encode_to_db('th');
            $query = $ObjDB->sql_build('INSERT', T_ORDER, $values);
            if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            $lastinsert = $ObjDB->sql_nextid();
        
        
        //Address
        $values = array();
        $values['order_id'] = (int)$lastinsert;
				$values['shipping_fname'] = encode_to_db($data['member_fname']);
				$values['shipping_lname'] = encode_to_db($data['member_lname']);
				$values['shipping_address'] = encode_to_db($data['member_address']);
				$values['shipping_moo'] = encode_to_db($data['member_moo']);
				$values['shipping_addr_type'] = encode_to_db($data['member_addr_type']);
				$values['shipping_soi'] = encode_to_db($data['member_soi']);
				$values['shipping_road'] = encode_to_db($data['member_road']);
				$values['shipping_tambon'] = encode_to_db($data['member_tambon']);
				$values['shipping_aumphur'] = encode_to_db($data['member_aumphur']);
				$values['shipping_province'] = encode_to_db($data['member_province']);
				$values['shipping_postcode'] = encode_to_db($data['member_postcode']);
				$values['shipping_phone'] = encode_to_db($data['member_phone']);
				$values['shipping_mobile'] = encode_to_db($data['member_mobile']);

				$values['porder_fname'] = encode_to_db($data['member_fname']);
				$values['porder_lname'] = encode_to_db($data['member_lname']);
				$values['porder_address'] = encode_to_db($data['member_address']);
				$values['porder_moo'] = encode_to_db($data['member_moo']);
				$values['porder_addr_type'] = encode_to_db($data['member_addr_type']);
				$values['porder_soi'] = encode_to_db($data['member_soi']);
				$values['porder_road'] = encode_to_db($data['member_road']);
				$values['porder_tambon'] = encode_to_db($data['member_tambon']);
				$values['porder_aumphur'] = encode_to_db($data['member_aumphur']);
				$values['porder_province'] = encode_to_db($data['member_province']);
				$values['porder_postcode'] = encode_to_db($data['member_postcode']);
				$values['porder_phone'] = encode_to_db($data['member_phone']);
				$values['porder_mobile'] = encode_to_db($data['member_mobile']);
            $query = $ObjDB->sql_build('INSERT', T_ORDER_ADDRESS, $values);
            if ( !($result = $ObjDB->sql_query($query)) ) {
                    message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            else{
                $response = update_address((int)$memberid,(int)$lastinsert);
            }
    }
    
    return $response;
}

function cancel_order($orderid=0){
    global $clsSession,$ObjDB;
    if($orderid!=0){
        $query = 'select * from '.T_PRODUCT_ORDER.' where `order_id` = '.$orderid;
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $skudata = $ObjDB->sql_fetchrowset($result);
        
        if(!empty($skudata)){
            foreach($skudata AS $index => $skuarrdata){
                $skuarrdata['psku_id'] = $skuarrdata['component_id']!=0 ? $skuarrdata['component_id'] : $skuarrdata['psku_id'];
                cancel_order_restore_sku_back((int)$skuarrdata['psku_id'],(int)$skuarrdata['value']);
            }
        }
        
        $response = remove_status_coupon((int)$orderid);
        $values = array();
        $values['date_cancel'] = 'NOW()';
        $values['status'] = (int)9;
        $query = $ObjDB->sql_build('UPDATE', T_ORDER, $values,' order_id = '.(int)$orderid);
            if ( !($result = $ObjDB->sql_query($query)) ) {  message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);
                    
            }else{
                        $cancel_operation = 1;
           }

    }
    $query = 'select * from '.T_ORDER_PAYMENT.' where order_id = '.(int)$orderid;
    if ( !($result = $ObjDB->sql_query($query)) ) {  message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query); }
    while($temp = $ObjDB->sql_fetchrow($result)){
        $payment_id[] = $temp['order_payment_id'];
    }
    if(!empty($payment_id)){
            $query = 'select * from '.T_ATTACH.' where content_id IN ('.implode(',',$payment_id).') and grp_content = \'Payment\'';
            if ( !($result = $ObjDB->sql_query($query)) ) {  message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            while($temp = $ObjDB->sql_fetchrow($result)){
                file_management::delete_files(BASEDIR_PAYMENT, $temp['filename']);
                $attach_id[] = $temp['att_id'];
            }
            
            if(!empty($attach_id)){
                    $query = 'delete from '.T_ORDER_PAYMENT.' where order_id = '.(int)$orderid;
                    if ( !($result = $ObjDB->sql_query($query)) ) {  message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            }
            
            if(!empty($payment_id)){
                    $query = 'delete from '.T_ATTACH.' where att_id IN ('.implode(',',$payment_id).')';
                        if ( !($result = $ObjDB->sql_query($query)) ) {  message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            }
            
    }
    
    
    return $cancel_operation;
}

function cancel_order_restore_sku_back($sku_id = 0,$value=0){
    global $clsSession,$ObjDB;
    if($sku_id!=0 && $value > 0){
        $query = 'UPDATE '.T_PRODUCT_SKU.' SET ';
        $query .= '  amount = amount + '.$value;
        $query .= '  ,sale_out = sale_out - '.$value;
        $query .= ' WHERE `psku_id` = '.$sku_id;
        $ObjDB->sql_query($query);
    }
}

function get_unit_sku($unit_id=0,$lang='th'){
    global $clsSession,$ObjDB;
    
    $query = 'select * from '.T_UNITSKU;
    if ( !($result = $ObjDB->sql_query($query)) ) {
          message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
    if(is_numeric($unit_id)){
        $string = 'ชิ้น';
        while($data = $ObjDB->sql_fetchrow($result)){
            if($data['unit_sku_id']==$unit_id){
                $string = $clsSession->getLangText($data['unit_skutxt'],$data['unit_skutxt_en'],$lang);
                break;
                }
        }
    }
    return $string;
}

function get_sku_unit($sku_id=0){
    global $clsSession,$ObjDB;
    if((int)$sku_id!=0){
        $query = 'select unit_sku from '.T_PRODUCT_SKU.' where psku_id = '.$sku_id;
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $skudata = $ObjDB->sql_fetchrow($result);
    }
    return $skudata['unit_sku'];
}

function get_com_sku_unit($comdata=array()){
    global $clsSession,$ObjDB;
    if(!empty($comdata)){
        
        foreach($comdata AS $index => $compodata){
            $comdata[$index]['unit_sku'] = get_sku_unit($compodata['component_id']);
        }
    }
    return $comdata;
}

function get_group_sap_order($group_id=0){
    global $clsSession,$ObjDB;
    if($group_id>0){
        $query = 'select `o`.*,`sg`.*,`sag`.`sap_group_code`,(`o`.`total` - `o`.`shipping`) AS `before_ship`,`op`.`date_payment` 
            ,`op`.`bank_id`, DATE(`op`.`date_create`) as `date_backup`,date(o.date_purchase) as date_bougth 
            ,sum(`op`.`payment_amount`) AS `real_pay`
            ,(`op`.`date_payment`) AS `Pay_date`
            ,(select sum(p_o.pay_point) from '.T_PRODUCT_ORDER.' as p_o where (p_o.order_id = o.order_id) limit 1) as pay_with_point
            ,IF((`op`.`time_payment`)!=\'\' ,`op`.`time_payment` ,TIME(`op`.`date_create`)) AS `pay_time`
            ,o.gold_coin as point_may_you_get ,`pro`.`free_item_code`';
        
        $query .= ' ,(select CONCAT(bank_name_th,"  ",branch_name_th) from '.T_BANK.' AS `ba1` where `ba1`.`bank_id` = `op`.`bank_id` group by `ba1`.`bank_id`) AS bank_name';
        $query .= ' ,(COUNT(`op`.`order_payment_id`)) AS `payment_time_freq`';
        
        $query .= ' from '.T_ORDER.' AS `o`';
        $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON `sg`.`shipping_group_id` = `o`.`shipping_group_id`';
        $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON ( `sag`.`sap_group_id` = `sg`.`sap_group_id` )';
        $query .= ' left join '.T_ORDER_PAYMENT.' AS `op` ON ( `o`.`order_id` = `op`.`order_id` ) 
                    left join '.T_PROMOTION.' as `pro` on (pro.promotion_id = o.promotion_id)';
        $query .= ' where `sag`.`sap_group_id` = '.$group_id;
        $query .= ' GROUP BY `o`.`order_id`';
        $query .= ' ORDER BY `bank_name` ASC';
        
        if ( !($result = $ObjDB->sql_query($query)) ) {
          message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
       
        while($tmp = $ObjDB->sql_fetchrow($result)){
            $tmp['Pay_date'] = (($tmp['Pay_date'] == '0000-00-00'||$tmp['Pay_date']=='')?$tmp['date_backup']:$tmp['Pay_date']);
            if( !empty($tmp['ro_code']) ){
                $tmp['order_code'] = decode_from_db($tmp['ro_code']);
            }
            $data[] = $tmp;
        }
        
        if(!empty($data)){
            foreach($data AS $index => $orderdata){
                if($orderdata['total_discount']>0){
                        $query = 'select oc.*,`c`.`coupon_book` from '.T_COUPON.' as c left join  '.T_ORDER_COUPON.' as oc on (oc.coupon_id=c.coupon_id) where oc.order_id = '.$orderdata['order_id'];
                        if ( !($result = $ObjDB->sql_query($query)) ) { message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                    
                    $data[$index]['coupon'] = $ObjDB->sql_fetchrow($result);
                }
                
                
                $query = 'select * from '.T_MEMBER.' where member_id = '.$orderdata['member_id'];
                    if ( !($result = $ObjDB->sql_query($query)) ) {
                        message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                $data[$index]['member'] = $ObjDB->sql_fetchrow($result);
            }
       }  
    }
    
    return $data;
}

function calendardate($month=0,$year=0){
    if($month > 0 && $year >0){
        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
    return $day;
}

function get_username($user_id=0){
global $clsSession,$ObjDB;
    if($user_id>0){
        $sql = 'select * from '.T_USER.' where user_id = '.$user_id;
        if ( !($result = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $username = $ObjDB->sql_fetchrow($result);
    }
    return $username['username'];
}

function get_approvelog($order_id=0,$step=''){
    global $clsSession,$ObjDB;
    if($order_id>0){
         $sql = 'select * from '.T_LOG_ORDER_APPROVE.' where order_id = '.$order_id.' AND to_step like \''.$step.'\' order by action_date DESC';
         if ( !($result = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $orderlog = $ObjDB->sql_fetchrow($result);
        $orderlog['username'] =  get_username($orderlog['user_id']);
    }
    return $orderlog;
}

function order_step($stepid=0){
    # 1: new order
    # 2: new order
    # 3: Shipping Option
    # 5: Shipping Product
    # 6: Order archive
    # 7: order limit
    # 9: order cancel
    # 10: Order management
    # 11: Complete Deleted
    if($stepid>0){
        switch ($stepid){
            case 1:
                $string = 'New Order';
                break;
            case 2:
                $string = 'New Order';
                break;
            case 3:
                $string = 'Shipping Option';
                break;
            case 4:
                $string = 'Packing Product';
                break;
            case 5:
                $string = 'Shipping Product';
                break;
            case 6:
                $string = 'Order archive';
                break;
            case 7:
                $string = 'order limit';
                break;
            case 8:
                $string = 'Order From Backend';
                break;
            case 9:
                $string = 'Order Cancel';
                break;
            case 10:
                $string = 'Order Management';
                break;
            case 11:
                $string = 'Complete Deleted';
                break;
        }
    }
    return $string;
}

function order_refresh($orderid=0){
    global $clsSession,$ObjDB;
    if($orderid>0){
        $query = 'select * from '.T_PRODUCT_ORDER.' where component_id = 0 and order_id = '.$orderid;
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $order = $ObjDB->sql_fetchrowset($result);
        
    }
    return $order;
}

function passthru_newsletter_sendmail($msg_id=0) {
        define('PHP_CLI2', 'C:\Program Files (x86)\PHP\php.exe');
	//$command = sprintf('"%s" "'.BASEDIR_ADMIN.'/api/e_news_mailer.php" %d ', PHP_CLI, $msg_id);
        $command = sprintf('"%s" "'.BASEDIR_ADMIN.'\demo.php" %d ', PHP_CLI2, $msg_id);
	//$command
	if (substr(php_uname(), 0, 7) == 'Windows') {
		//pclose(popen("start /B ".$command." 2>&1", "r"));
		pclose(popen('start /B '.$command, 'r'));
	} else {
		exec($command." > /dev/null &");
	}
        

}


function sap_status($status=0){
if($status>0){
   switch ($status){
       case 1:
           $string = 'Shipping Product';break;
       case 2:
           $string = 'Order Archive';break;
       case 9:
           $string = 'Cancelled';break;
   }
 }
 return $string;
}

function get_product_for_sapreport($sapid=0){
    if($sapid>0){
        global $ObjDB,$clsSession;
        $defaultdate = '`o`.`date_arrangement`';
        $Condition[] = '`o`.`status` = 5';
        $Condition[] = '`o`.`date_purchase` != \'0000-00-00 00:00:00\'';
        
        $strCond = implode(' AND ', $Condition);
        
        $query = 'select `sap_group_id` from '.T_SAP_GROUP.' where `sap_group_id` = '.(int)$sapid;
        if ( !($result = $ObjDB->sql_query($query)) ) {
            message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
        $data = $ObjDB->sql_fetchrow($result);
        if(!empty($data)){
            $query = 'select `o`.`order_id` ';
            $query .= ' from '.T_ORDER.' AS `o` ';
            $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON (`sg`.`shipping_group_id` = `o`.`shipping_group_id`)';
            $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON (`sg`.`sap_group_id` = `sag`.`sap_group_id`) ';
            $query .= ' WHERE ('.$strCond.' AND `sag`.`sap_group_id` = '.(int)$sapid.') ';
            if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
            
            $order_info = $ObjDB->sql_fetchrowset($result);
            foreach($order_info AS $index => $arrdata){
                if((int)$arrdata['order_id']>0){
                    $ordergroupid[] = $arrdata['order_id'];

                }
            }
if ( $ordergroupid ) {
    $inorder = "(".implode(",",$ordergroupid).")";
    $query = '
                SELECT `p`.`psku_id`, `component_id`, `p`.`price`, SUM(`value`) AS `t_value`, GROUP_CONCAT(`t`.`order_id`) 
                ,`p`.`product_title_th`, `p`.`product_title_en`,`p`.`product_code`, p.pay_point
                ,IF((select `pcat_id` from '.T_PRODUCT_SKU.' where `psku_id` = `p`.`psku_id`)=7,1,0) AS `Isset`
                FROM '.T_PRODUCT_ORDER.' AS `p`
                LEFT JOIN (
                SELECT `order_id`, `psku_id`, GROUP_CONCAT(`comval`) AS `comvalx` FROM (
                SELECT `o`.`order_id`, `o`.`psku_id`, `o`.`component_id`, `o`.`price`, o.`value`, CONCAT(s.component_id, ".", s.price, "|", o.component_id, ".", ROUND(`o`.`value`/`s`.`value`), ".", o.price) AS `comval`
                FROM '.T_PRODUCT_ORDER.' AS `o`
                LEFT JOIN '.T_PRODUCT_ORDER.' AS `s` ON `o`.`order_id`=`s`.`order_id` AND `s`.`psku_id`=`o`.`psku_id` AND `s`.`component_id`=0
                WHERE `o`.`order_id` IN '.$inorder.' AND `o`.`component_id` > 0
                ORDER BY `o`.`order_id`, `o`.`psku_id`, `o`.`component_id`
                ) AS `t`
                GROUP BY `order_id`, `psku_id`
                ) AS `t` ON `p`.`psku_id`=`t`.`psku_id` AND `t`.`order_id`=`p`.`order_id`
                WHERE `p`.`order_id` IN '.$inorder.'
                GROUP BY `p`.`psku_id`, `p`.`component_id`, `p`.`price`, `comvalx`
                ORDER BY p.pay_point asc, `p`.`porder_id` ASC';

    if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    $Content['list'] = $ObjDB->sql_fetchrowset($result);
}

            $query = 'SELECT SUM(`o`.`promotion_value`) AS `total_quantity`,pro.product_code';
            $query.= ' ,`o`.`promotion_id` AS `promotion_id` , `o`.`promotion_title_th`, `o`.`free_item_code`, `o`.`free_item_value`';
            $query.= ' FROM '.T_ORDER.' AS `o` ';
            $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON (`sg`.`shipping_group_id` = `o`.`shipping_group_id`)';
            $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON (`sg`.`sap_group_id` = `sag`.`sap_group_id`) 
                        left join '.T_PROMOTION.' AS `pro` ON (`pro`.`promotion_id` = `o`.`promotion_id`)';
            $query.= ' WHERE ('.$strCond.'  AND `sag`.`sap_group_id` = '.(int)$sapid.' AND `o`.`promotion_title_th`!=\'\')';
            $query.= ' GROUP BY  `o`.`promotion_id`,`o`.`free_item_code`';
            if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            $Content['summary']['freeitem'] = $ObjDB->sql_fetchrowset($result);
            
            $query = 'SELECT ';
            $query.= ' COUNT(`ec`.`coupon_id`) AS `total_coupon`, `coupon_remark`, (`ec`.`discount_price`) AS discount_price
                ,`ec`.`coupon_book`,oc.coupon_code ';
            $query.= ' FROM '.T_ORDER.' AS `o` ';
            $query.= ' LEFT JOIN '.T_ORDER_COUPON.' AS `oc` ON (`oc`.`order_id` = `o`.`order_id`)';
            $query.= ' LEFT JOIN '.T_COUPON.' AS `ec` ON (`ec`.`coupon_id` = `oc`.`coupon_id`)';
            $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON (`sg`.`shipping_group_id` = `o`.`shipping_group_id`)';
            $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON (`sg`.`sap_group_id` = `sag`.`sap_group_id`) ';
            $query.= ' WHERE ('.$strCond.'  AND `sag`.`sap_group_id` = '.(int)$sapid.' AND `oc`.`coupon_code`!=\'\' AND `ec`.`coupon_book`!=\'\')';
            $query.= ' GROUP BY  (`ec`.`coupon_book`)';
            if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            $Content['summary']['coupon'] = $ObjDB->sql_fetchrowset($result);
            
            $query = 'SELECT ';
            $query.= ' SUM(`o`.`shipping`) AS `sum_total_shipping`, SUM(IF(`o`.`shipping`>0,1,0)) AS `shipping_time`,`o`.`shipping_rate_id`,`o`.`shipping_rate_title`
                , `ship`.`condition`,SUM(IF(`o`.`shipping`=`o`.`shipping`,1,0)) AS `count_time`, `o`.`shipping_rate_condition` , o.shipping as total_shipping ';
            $query.= ' FROM '.T_ORDER.' AS `o` ';
            $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON (`sg`.`shipping_group_id` = `o`.`shipping_group_id`)';
            $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON (`sg`.`sap_group_id` = `sag`.`sap_group_id`) 
                left join '.T_SHIPPING.' AS `ship` ON (`o`.`shipping_rate_id`=`ship`.`shipping_id`)';
            $query.= ' WHERE ('.$strCond.'  AND `sag`.`sap_group_id` = '.(int)$sapid.')
                GROUP BY `o`.`shipping` ';
            if ( !($result = $ObjDB->sql_query($query)) ){ message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            
            while($tmp = $ObjDB->sql_fetchrow($result)){
                    if(!($tmp['total_shipping']==0 && ($tmp['shipping_rate_condition']==0 || $tmp['shipping_rate_condition']==''))){
                            if($tmp['total_shipping']>0 && ($tmp['shipping_rate_id']==0 || $tmp['shipping_rate_id']=='')){
                                    $tmp['condition'] = (int)$clsSession->get_config('Price_Minimum');
                                    $tmp['shipping_rate_title'] = 'Default';
                                    $tmp['shipping_rate_condition'] = (int)$clsSession->get_config('Price_Minimum');
                                    $tmp['total_shipping'] =  (int)$clsSession->get_config('Shipping');
                             }
                                    $tmp['condition_txt'] = static_text::shipping_text($tmp);

                    }else
                        unset($tmp);
                    $Content['summary']['shipping'][] = $tmp;
            }

        }
    }
    return $Content;
}

function get_order_approveuser($orderid=0,$instep=0){
    if($orderid!=0 && $instep!=0){
        global $ObjDB;
        
        $query = 'SELECT (select `name` from '.T_USER.' where `user_id` = `log_oa`.`user_id` ) AS `username` FROM '.T_LOG_ORDER_APPROVE.' AS `log_oa` WHERE (`log_oa`.`order_id` = '.(int)$orderid.' AND `log_oa`.`to_step` = '.(int)$instep.') ORDER BY `log_oa`.`action_date` DESC limit 1';
        
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $datauser = $ObjDB->sql_fetchrow($result);
    }
   return $datauser['username']; 
}

function delete_neworder_colpletely($orderid=''){
    if( $orderid ){
        global $ObjDB;$responses = 0;
        $orderid = base64_decode($orderid);
        if( is_numeric($orderid) || $orderid > 0 ){
            
            
            $query = 'select * from '.T_ORDER.' where `status` = 8 AND `order_id` = '.$orderid;
            if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            $order = $ObjDB->sql_fetchrow($result);
            if( !empty($order) ){
                
                
                $query = 'DELETE FROM '.T_ORDER.' where `status` = 8 AND `order_id` = '.$orderid.' limit 1';
                if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
                else $response[0] = 1;
                $query = 'DELETE FROM '.T_ORDER_ADDRESS.' where `order_id` = '.$orderid.' limit 1';
                if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
                else $response[1] = 1;
            }
        }
    }
    if( $response[0] = 1 && $response[1] = 1){
        $responses = 1;
        create_log_order_approve((int)$orderid,10,11,'Complete Delete',$order['order_code']);
    }
    
    return $responses;
}

function cancel_orders($order_id=0,$fromstep=0){
    if( $order_id && $fromstep){
        global $ObjDB;
        $query = 'select `order_id` from '.T_ORDER.' where `order_id` = '.$order_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrow($result);
        
        create_log_order_approve((int)$orderid,10,11,'Complete Delete',$order['order_code']);
        
    }
    return $response;
}

function get_pay_user($order_id=0){
    if( $order_id >0){
        global $ObjDB;
        $query = 'select if(`user_create`=0,"Customer",`user_create`)  AS `user_create` , `payment_type` from '.T_ORDER_PAYMENT.' where `order_id` = '.$order_id.' ORDER BY `order_payment_id` DESC limit 1';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrow($result);
        
        if( is_numeric($data['user_create'])){
            if( (int)$data['user_create'] > 0 ){
            $query = ' select `name` from '.T_USER.' where `user_id` = '.(int)$data['user_create'];
            if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            $admin = $ObjDB->sql_fetchrow($result);
            $string = $admin['name'];
            }
        }else if( $data['user_create']=="Customer" && $data['payment_type']==1){
            $string = "KASIKORNBANK";
        }else if( $data['user_create']=="Customer"){
            $string = "Customer";
        }
        else $string = "";
    }
    return $string;
}

function delete_product($p_order_id = 0){
    if( $p_order_id > 0){
        global $ObjDB;
        $query = 'DELETE from '.T_PRODUCT_ORDER.' where `porder_id` = '.$p_order_id.' limit 1';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    }
}

function kick_status($kickstep=''){
    if( $kickstep != '' ){
        $kickstep = strtolower($kickstep);
        switch ($kickstep) {
            case 'approve' :
                $string = 'Approve';
                break;
            case 'cancel' :
                $string = 'Cancel';
                break;
            case 'revert' :
                $string = 'Revert';
                break;
        }
    }
    return $string;
}


function addproduct_order($postpara=array()){
    if($postpara['Id']!=0 && $postpara['psku_id']!=0 && $postpara['quantity']>0){
        global $ObjDB,$clsSession;
        $query = 'select * ,IF(`sku`.`promotion_date_active` != \'0000-00-00\' AND `sku`.`promotion_date_expired` != \'0000-00-00\',IF((CURDATE() BETWEEN `sku`.`promotion_date_active` AND `sku`.`promotion_date_expired`),`sku`.`sale`,`sku`.`price`),`sku`.`price`) AS `Price` ,`sku`.`title_th` AS `product_name_th`,`sku`.`title_en` AS `product_name_en`
            from '.T_PRODUCT_SKU.' AS `sku` LEFT JOIN '.T_UNIT.' AS `unit` ON `unit`.`unit_id`= `sku`.`unit_id`';
        $query .= 'WHERE `sku`.`psku_id` = '.$postpara['psku_id'];
        $result = $ObjDB->sql_query($query);
        $data = $ObjDB->sql_fetchrow($result);
        
        $orderdata = get_order((int)$postpara['Id']);
        
        $values = array();
        $values['user_modify'] = (int)$clsSession->get_auth('Id');
        $values['order_mod_date'] = 'NOW()';
        if($orderdata['status']==8) // 8 is neworder
                $values['status'] = 1;
        
        $query = $ObjDB->sql_build('UPDATE', T_ORDER, $values,'order_id = '.$postpara['Id'],1);
        $ObjDB->sql_query($query);
        
        if(!empty($data)){
            $getspecial = false;
            if($data['free_item_promotion']==1) $getspecial = true;
            
            if($data['pcat_id']==7 && $data['type']==3){//if product is set
                
                $singlesku = check_order_product_data($postpara);
                
                if(empty($singlesku)){
                    $result = insert_psku($postpara,$data);
                    $component = array();
                    $component = get_product_components($postpara['psku_id']);
                    
                    $result = insert_component_set($component,$postpara['quantity'],$postpara['Id']);
                }
                else{
                    $setdata = get_product_specialset_component($postpara['psku_id']);
                    
                    foreach($setdata AS $index => $comdata){
                        $value = ($comdata['quantity'] * $postpara['quantity']);
                       
                        update_product($comdata['product_id'],$value,2,$postpara['Id'],'+');
                    }
                    
                   update_product($postpara['psku_id'],$postpara['quantity'],1,$postpara['Id'],'+');

                }
            }
            else{// if not a set
                $singlesku = check_order_product_data($postpara);
                
                if(empty($singlesku)){
                    $result = insert_psku($postpara,$data);
                }
                else{
                    $query = 'update '.T_PRODUCT_ORDER.'';
                    $query .= ' set `value` = `value` +'.$postpara['quantity'];
                    $query .= ' where `order_id` = '.$postpara['Id'].' AND `psku_id` = '.$postpara['psku_id'].' AND `component_id` = 0';
                    $result = $ObjDB->sql_query($query);
                    
                    $query = ' update '.T_PRODUCT_SKU.' SET `amount` = `amount` - '.$postpara['quantity'];
                    $query .= ' ,`sale` = `sale` + '.$postpara['quantity'];
                    $query .= ' where `psku_id` ='.$postpara['psku_id'];
                    $result = $ObjDB->sql_query($query);
                }
            }
            refresh_table_order($postpara['Id'],$getspecial);
            
        }
    }
}

function check_payment_type($order_id=0){
    if ($order_id>0){
        global $ObjDB;
        $query =' select `payment_type` from '.T_ORDER_PAYMENT.' where `order_id` = '.$order_id.' order by `order_payment_id` desc';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $string = $ObjDB->sql_fetchrow($result);
    }
    return get_payment_type_be(decode_from_db($string['payment_type']));
}

function get_sku($sku_id=0,$compare_quantity=0){
    if( $sku_id > 0 ){
        global $ObjDB,$clsSession;
        
        $query  = 'select *,(IF((`b`.`hot_promotion`=1 AND CURDATE() BETWEEN `b`.`promotion_date_active` AND `b`.`promotion_date_expired`),`b`.`sale`,`b`.`price`)) AS `real_price` 
            from '.T_PRODUCT_SKU.' AS `b`';
        $query .= 'LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`b`.`psku_id`) ';
        $query .= ' where `b`.`psku_id` = '.$sku_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        //$sku_data = $ObjDB->sql_fetchrow($result);
        
        while($data = $ObjDB->sql_fetchrow($result)){
            $data['image_url'] = BASEURL.'/images/default_image_1.gif';
				if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) {
					$data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
					$_arr = IO::autoImageSize($data['image_width'], $data['image_height'], 80, 60);
					$data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
				} else 
					$data['image_width'] = 80; $data['image_height'] = 60;
                                        
            $data['title_th_sta'] = $data['title_th'].'<br />'.status_sku_text($data['psku_id']);
            $data['compare_quantity'] = $compare_quantity;
            if( is_sku_SET($data['psku_id']) )
            $data['component'] = get_product_specialset_component($data['psku_id']);
            
            $sku_data = $data;
	}
        
    }
    
    return $sku_data;
}

function status_sku_text($sku_id=0,$method=0)
{// $method || 0 = Default,1 = getdisable number return [0,1]
    if( $sku_id > 0 ){
        global $ObjDB,$clsSession;
        
        $query ='select `amount`,`point_stat`,(IF((CURDATE() BETWEEN `date_active` AND `date_expired`),1,0)) AS `still_sale` from '.T_PRODUCT_SKU.' where `psku_id` = '.$sku_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $status_data = $ObjDB->sql_fetchrow($result);
        
            if( $status_data['amount']<=0 )
            {
                $string = sku_status(3);
                if($method==1)
                    $string = 1;
            }
            else if( $status_data['still_sale']==0 )
            {
                $string = sku_status(2);
                if($method==1)
                    $string = 1;
            }
            else
            {
                $string = sku_status(1);
                if($method==1)
                    $string = 0;
            }
    }
    return $string;
}

function get_member_data($member_id=0){
    global  $ObjDB,$clsSession;
    if($member_id>0){
        
        $query = 'select *,CONCAT(`member_fname`,"  ",`member_lname`) AS `fullname` from '.T_MEMBER.' where `member_id` = '.$member_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $memberdata = $ObjDB->sql_fetchrow($result);
        
    $date = date("d-m-Y",strtotime($memberdata['member_birthday']));
    $date = (explode('-',$date));
    $date[2] = (int)$date[2] + 543;
    $memberdata['member_birthday'] = $date = implode('-',$date);
    
    //shipping address And order address
    $query = 'select `order_id` from '.T_ORDER.' where `member_id` = '.$member_id.' order by `order_id` DESC LIMIT 1';
    if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    $lastorder_data = $ObjDB->sql_fetchrow($result);
    
    if (!empty($lastorder_data)){
        $memberdata['has_order'] = 1;
        
        $query = 'select * from '.T_ORDER_ADDRESS;
        $query .= ' where `order_id` = '.$lastorder_data['order_id'];
        $query .= ' order by `order_id` DESC limit 1';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $shipdata = $ObjDB->sql_fetchrow($result);
        if( !empty($shipdata) )
            $memberdata['has_address'] = 1;
        $memberdata['shippingAdd'] = $shipdata;
    }

    }
    return $memberdata;
}

function compare_order_data($oldorder=array(),$neworder=array()){
    if(!empty($oldorder) && !empty($neworder)){
        foreach($oldorder['Products'] AS $index => $orderdata){
            $olddata[$orderdata['psku_id']] = $orderdata['total_price'];
        }
        foreach($neworder AS $index => $orderdata){
            $newdata[$orderdata['psku_id']] = ($orderdata['real_price']*$orderdata['compare_quantity']);
        }
    }
    foreach($olddata AS $skuid => $qty){
        $diff[$skuid] = ($newdata[$skuid] - $olddata[$skuid]);
    }
    return $diff;
}

function reorder_sku($sku_id='',$qty=0,$special_per=array())
{
    if($sku_id!=''&&$qty>0)
    {
        global  $ObjDB,$clsSession;
        $product_amt_limit = $clsSession->get_config('Product_Limit');
        
        $query = 'select `sku`.`pcat_id`,`sku`.`type`,`sku`.`amount`
            ,`sku`.`psku_id`,(IF((CURDATE() BETWEEN `sku`.`promotion_date_active` AND `sku`.`promotion_date_expired` AND `sku`.`hot_promotion`=1)
            ,`sku`.`sale`,`sku`.`price`)) AS `price`,`sku`.`free_item_promotion`, (`u`.`title_th`) AS `unit_th` ,(`u`.`title_en`) AS `unit_en`
            ,`sku`.`product_code`, `sku`.`description_th`, `sku`.`description_en`, `sku`.`title_th`, `sku`.`title_en`
            , `sku`.`sale` , if(sku.is_reward_hot = 1 and (curdate() between date(sku.reward_hot_active) and date(sku.reward_hot_expire) ),sku.reward_hot_sale,sku.reward_point) as qpoint_trade';
        
        $query .= ' from '.T_PRODUCT_SKU.' AS `sku` ';
        $query .= ' LEFT JOIN '.T_UNIT.' AS `u` ON (`sku`.`unit_id` = `u`.`unit_id`) ';
        $query .= ' where `sku`.`psku_id` in ('.$sku_id.') limit 1 ';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $sku_data = $ObjDB->sql_fetchrow($result);
        
            if($sku_data['type']==3&&$sku_data['pcat_id']==7)
            $sku_data['component'] = get_product_specialset_component($sku_data['psku_id'],$qty);
        
            $sku_data['order_quantity'] = ($qty*1);
            $sku_data['total_value_order'] = ($sku_data['order_quantity']*$sku_data['price']);
            $sku_data['over_stock'] = ($sku_data['order_quantity']>$sku_data['amount']?1:0);
            $sku_data['over_limit'] = ($sku_data['order_quantity']>$product_amt_limit?1:0);

            if( isset($special_per[$sku_data['psku_id']]) && (int)$sku_data['qpoint_trade'] > 0 )
            {
                $sku_data['price'] = 0;
                $sku_data['sale'] = 0;
                $sku_data['point_trade'] = $sku_data['qpoint_trade'];
            }
            else
            {
                $sku_data['point_trade'] = 0;
            }
        
    }
    return $sku_data;
}

function get_last_order($order_id=0)
{
    if($order_id>0){
        global  $ObjDB,$clsSession;
        $query = 'select *,(IF(`po`.`component_id`>0,`po`.`component_id`,`po`.`psku_id`)) AS `real_skuid` 
            , (IF( CURDATE() BETWEEN date(sku.`date_active`) AND date(sku.`date_expired`) ,1,0)) AS `still_sale`
            from '.T_PRODUCT_ORDER.' as `po`
        LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`po`.`psku_id`) 
        left join '.T_PRODUCT_SKU.' as sku on ( sku.psku_id = (IF(`po`.`component_id`>0,`po`.`component_id`,`po`.`psku_id`)) )
	LEFT JOIN '.T_IMAGE.' AS `e` ON (`e`.`grp_content`=\'Product_Sku_Thumb\' AND `e`.`content_id`=`po`.`component_id` ) ';
        $query.= ' where `po`.`order_id` = '.$order_id.' AND `component_id` = 0 group by sku.psku_id ';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }

        while($data = $ObjDB->sql_fetchrow($result)){
            
            $data['image_url'] = BASEURL.'/images/default_image_1.gif';
            if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) {
                    $data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
                    $_arr = IO::autoImageSize($data['image_width'], $data['image_height'], 80, 60);
                    $data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
            } else {
                    $data['image_width'] = 80; $data['image_height'] = 60;
            }
            
            //$data['disable'] = status_sku_text($data['real_skuid'],1); Remove By Ake on 2013/12/16
            //$data['txt_status'] = status_sku_text($data['real_skuid']);  Remove By Ake on 2013/12/16
            
            if( (int)$data['point_stat'] != 1)
            {
                if( $data['amount']<=0 )
                {
                    $data['txt_status'] = sku_status(3);

                    $data['disable'] = 1;
                }
                else if( $data['still_sale']==0 )
                {
                    $data['txt_status'] = sku_status(2);
                    $data['disable'] = 1;
                }
                else
                {
                    $data['txt_status'] = sku_status(1);
                    $data['disable'] = 0;
                }
            }
            else
            {
                $data['disable'] = 0;
                $data['txt_status'] = sku_status(4);
            }
            
                    $skudata = present_status_sku($data['real_skuid']);
                    $data['past_value'] = $data['value']* $data['price'];
                    $data['present_stock_balance'] = $skudata['amount'];
                    $data['present_price'] = $skudata['price'];
                    $data['present_value'] = ($skudata['price']*$data['value']);
                    $data['diff_value'] = ($skudata['price']*$data['value'])-($data['value']* $data['price']);
             if( is_sku_SET($data['real_skuid']) )
             {
                    $resultcom = checkcomponent($data['real_skuid']);
                    if( count($resultcom['amount'])  > 0 )
                    {
                        $data['txt_status'] = sku_status(3);
                        $data['disable'] = 1;
                    }
                    unset($resultcom);
                    $data['components'] = get_product_specialset_component($data['real_skuid'],$data['value'],$order_id);}
             
            
            $order_data[] = $data;
        }
    }
   // myprint($order_data);
    return $order_data;
}

function present_status_sku($sku_id=0){
    if($sku_id>0){
        global  $ObjDB;
        $query = 'select `amount`,(IF(`hot_promotion`=1 AND CURDATE() BETWEEN `promotion_date_active` AND `promotion_date_expired` ,`sale`,`price`)) AS `price`, `sale` from '.T_PRODUCT_SKU.' where `psku_id` = '.$sku_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        $data = $ObjDB->sql_fetchrow($result);
    }
    return $data;
}

function get_order_id($group_id=0,$mode=1){
    #mode : 1 == Shipping Group , mode : 2 == Sap group
    #Return Array Order_id
    if($group_id>0){
        global  $ObjDB;
        
        if( $mode == 1)
            $srt_con = ' `sg`.`shipping_group_id` = '.$group_id;
        else if ($mode == 2)
            $srt_con = ' `sag`.`sap_group_id` = '.$group_id;
        else
            $srt_con =' 1 ';
        
        $query = 'select `order_id` ';
        $query .= ' from '.T_ORDER.' AS `o` ';
        $query .= ' left join '.T_SHIPPING_GROUP.' AS `sg` ON (`sg`.`shipping_group_id` = `o`.`shipping_group_id`)';
        $query .= ' left join '.T_SAP_GROUP.' AS `sag` ON (`sag`.`sap_group_id` = `sg`.`sap_group_id`)';
        $query .= ' where '.($srt_con);
        
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        
        while($data = $ObjDB->sql_fetchrow($result)){
            $order_id[] = $data['order_id'];
        }
    }
    
    return $order_id;
}

function bank_report($sapgroup=0){
    if( $sapgroup>0 ){
        global  $ObjDB;
        $order_group_id = get_order_id($sapgroup,2);
        $str_con = implode(",",$order_group_id);
        if( !empty($order_group_id) ){
            $query = 'select o.ro_code,`o`.`order_code`,`op`.*,CONCAT(`b`.`bank_name_th`,"  ",`b`.`branch_name_th`) AS `bank_Fname`,DATE(`op`.`date_create`) AS `date_create_D`,TIME(`op`.`date_create`) AS `date_create_T`, `op`.`user_create`
                        , sum(po.pay_point * po.value) as pay_with_point ';
            $query .= ' from '.T_ORDER.' AS `o` ';
            $query .= ' left join '.T_ORDER_PAYMENT.' AS `op` ON (`op`.`order_id` = `o`.`order_id`) 
                        left join '.T_PRODUCT_ORDER.' as po on po.order_id = o.order_id ';
            $query .= ' left join '.T_BANK.' AS `b` ON (`b`.`bank_id` = `op`.`bank_id`) ';
            $query .= ' where `o`.`order_id` IN ('.($str_con).') group by op.order_payment_id ';
            if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
            while($data = $ObjDB->sql_fetchrow($result)){

                $data['date_payment'] = ((empty($data['date_payment']) || $data['date_payment']=='0000-00-00') ? $data['date_create_D']:$data['date_payment']);
                
                $data['member_payment'] = get_pay_user($data['order_id']);
                
                $data['neworderapp'] = get_order_approveuser($data['order_id'],3);
                
                $data['time_payment'] = ((empty($data['time_payment'])|| $data['time_payment']==':'|| $data['time_payment']=='')?$data['date_create_T']:$data['time_payment']);;
                if( !empty($data['ro_code']) ){
                    $data['order_code'] = decode_from_db($data['ro_code']);
                }
                $bank_report[] = $data;
            }
        }
    }
    
    return $bank_report;
}

function check_set_special_compo($set_special_id=0,$qty=0){
    if($set_special_id>0 && $qty>0){
        $query = 'select `product_id` from '.T_PRODUCT_SPECIALSET.' where special_set_id = '.$set_special_id;
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
       $sku_id = $ObjDB->sql_fetchrow($result);
            

    }
    return ;
}

function get_shipping_codes($sapid=0){
    if($sapid>0){
        global  $ObjDB;
        $order_id = get_order_id($sapid,2);
        $order_id = implode(",",$order_id);

        $query = 'SELECT `sg`.`shipping_code` FROM '.T_SHIPPING_GROUP.' AS `sg` left join '.T_ORDER.' As `o` ON (`o`.`shipping_group_id` = `sg`.`shipping_group_id`) where `o`.`order_id` IN ('.$order_id.') GROUP BY `sg`.`shipping_code`';
        if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
        while($data = $ObjDB->sql_fetchrow($result)){
            $shipping_code[] = $data['shipping_code'];
        }
    }
    return $shipping_code;
}

function build_sku_data($strcon='',$para=array())
{
    if( $strcon )
    {
        global $ObjDB;
    
        $query = 'select psku_id from '.T_PRODUCT_SKU.'as `a`';
        $query .= ' where ( '.$strcon.' )';
        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query);}
       $data = $ObjDB->sql_fetchrowset($result);

       $total_rec = count($data);

        $query = 'SELECT `d`.*,`a`.*, (IF( CURDATE() BETWEEN date(a.`date_active`) AND date(a.`date_expired`) ,1,0)) AS `still_sale` ,`b`.`title_th` as `unit_txt_th`,(IF((CURDATE() BETWEEN `a`.`promotion_date_active` AND `a`.`promotion_date_expired`) AND `a`.`hot_promotion`=1,`a`.`sale`,`a`.`price`)) as `real_price` ';
        $query.= ' from '.T_PRODUCT_SKU.'as `a`';
        $query.= ' LEFT JOIN '.T_UNIT.' AS `b` ON (`a`.`unit_id`=`b`.`unit_id`) ';
        $query.= ' LEFT JOIN '.T_IMAGE.' AS `d` ON (`d`.`grp_content`=\'Product_Sku_Thumb\' AND `d`.`content_id`=`a`.`psku_id`) ';
        $query .= ' WHERE ( '.$strcon.' ) group by a.psku_id ';
        $query.= ' ORDER BY '.$para['field_sort_by'].' '.$para['sort_mode'];
        $query.= ' LIMIT '.(int)$para['start'].', 10';

        if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query);}
        $data = array();
        while($data = $ObjDB->sql_fetchrow($result))
        {

           $data['image_url'] = BASEURL.'/images/default_image_1.gif';
                if (IO::CheckFileExists(BASEDIR_PRODUCT_SKU, $data['image_name'])) 
                {
                       $data['image_url'] = BASEURL_PRODUCT_SKU.'/'.$data['image_name'];
                       $_arr = IO::autoImageSize($data['image_name'], $data['image_name'], 130, 100);
                       $data['image_width'] = $_arr['Width']; $data['image_height'] = $_arr['Height'];
                }
                else 
                    $data['image_width'] = 130; $data['image_height'] = 100;
                    
                //$data['disable'] = status_sku_text($data['psku_id'],1);  Remove By Ake on 2013/12/16
                //$data['txt_status'] = status_sku_text($data['psku_id']);  Remove By Ake on 2013/12/16
                
                if( (int)$data['point_stat'] != 1)
                {
                    if( $data['amount']<=0 )
                    {
                        $data['txt_status'] = sku_status(3);

                        $data['disable'] = 1;
                    }
                    else if( $data['still_sale']==0 )
                    {
                        $data['txt_status'] = sku_status(2);
                        $data['disable'] = 1;
                    }
                    else
                    {
                        $data['txt_status'] = sku_status(1);
                        $data['disable'] = 0;
                    }
                }
                else
                {
                    $data['disable'] = 0;
                    $data['txt_status'] = sku_status(4);
                }

                $sku_data['list'][$data['psku_id']] = $data;
           }
           $sku_data['pageNav']['total_rec'] = $total_rec;

    }
        return $sku_data;
}

function get_shipping_rate_b($total_value=0){
    if($total_value>0){
        global $ObjDB,$clsSession;
        
        $Condition = array();
        //$Condition[] = '`shipping_status` = 1';
        $Condition[] = '`condition` > '.$total_value;
        $strcon = implode(" AND ",$Condition);
        
        $query = 'select * from '.T_SHIPPING.' where '.$strcon.' ORDER BY `shipping_id` DESC limit 1';
        if ( !($result = $ObjDB->sql_query($query)) ) {
            message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query);}
        $tmp = $ObjDB->sql_fetchrow($result);
        
        if(empty($tmp)){/* Default Condition Shipping Rate In Config*/
            $tmp['value'] = (int)$clsSession->get_config('Shipping');
            $tmp['condition'] = (int)$clsSession->get_config('Price_Minimum');
            $tmp['title_code'] = 'Default';
            }
    }
    return $tmp;
}
//BTN Display
function backend_new_order($order_status=array()){
    
    $string['approve_btn'] = '<input type="checkbox" name="order['.$order_status['order_id'].']" class="cb_toggle"  value="'.$order_status['order_id'].'" />';
    $string['print_pur'] = '<div><a href="print_purchase.php?order_id='.$order_status['order_id'].'" class="btPrint" title="ใบสั่งซื้อ"></a></div>';
    $string['print_deliver'] = '<div><a href="print_delivery.php?order_id='.$order_status['order_id'].'" class="btPrint" title="ใบจัดของ"></a></div>';
    
    
    if($order_status['status']==8){
        $string['approve_btn'] = '';
        $string['print_pur'] = '<div><a href="'.$order_status['Url'].'&amp;action=cancel&amp;orderset='.($order_status['order_id']).'" class="btCancel" title="ยกเลิกออเดอร์"></a></div>';
        $string['print_deliver'] = '';
    }
    return $string;
}

function btn_alldisplay($baseUrl=array(),$company=0,$groupid=0){
   if( $company > 0 && $groupid > 0 ){
       
       $string['edit'] = '<a href="'.$baseUrl.'&amp;action=edit&amp;Id='.$groupid.'" class="btEdit" title="Edit"></a>';
       
       $string['shipping_group'] = (in_array($company,array(2))?'<a href="inter_shipping_group.php?group_id='.$groupid.'" id="btPrints" class="btPrintstyle2 btprintdias" title="ใบรับฝากอินเตอร์"></a>':'<a href="shipping_group.php?group_id='.$groupid.'" class="btPrint" title="สรุปใบนำส่งสิ่งของส่งทางไปรษณีย์"></a>');
       
       $string['shipping_order'] = (in_array($company,array(2)))?'':'<a href="print_shipping.php?order_ship_id='.$groupid.'&amp;type=group" class="btPrint" title="รายงานนำส่งสิ่งของส่งทางไปรษณีย์"></a>';
       
       $string['shipping_order_all'] = (in_array($company,array(2)))?'':'<a href="print_all_shipping.php?group_id='.$groupid.'" class="btPrint" title="ใบรับฝากรวม"></a>';
       
       if(in_array($company,array(3))){
           $string['shipping_order_all'] = $string['shipping_order'] = $string['shipping_group'] = '';
       }
       $string['label'] = '<a href="print_label3.php?group_id='.$groupid.'&amp;type=group" id="btPrints" class="btPrints btPrintlabel" title="ใบแปะกล่อง"></a>';
       
       $string['print_purchase'] = '<a href="print_purchase.php?group_id='.$groupid.'" class="btPrint" title="ใบสั่งซื้อทั้งหมด"></a>';
       
       $string['print_delivery'] = '<a href="print_delivery.php?group_id='.$groupid.'" class="btPrint" title="ใบจัดของทั้งหมด"></a>';
       
       $string['print_invoice'] = '<a href="print_invoice.php?group_id='.$groupid.'" class="btPrint" title="ใบเสร็จทั้งหมด"></a>';
       
   }
   return $string;
}

function btn_ordinary_step($baseUrl=array(),$order_id=0,$order_data=Array())
{
    if( $order_id > 0 ){
        $string = '
	<div><a href="'.$baseUrl.'&amp;action=view&amp;Id='.$order_id.'" class="btView" title="View"></a></div>
	<div><a href="print_purchase.php?order_id='.$order_id.'" class="btPrint" title="'.($order_data['po_ro_title']).'"></a></div>
	<div><a href="print_delivery.php?order_id='.$order_id.'" class="btPrint" title="ใบจัดของ"></a></div>
	<div><a href="print_invoice.php?order_id='.$order_id.'" class="btPrint" title="ใบเสร็จ"></a></div>
        '.(permission_funcv1()?'
        <div>'.trade_order_paper(1,$order_id,$order_data['paywithpoint']).'</div>':'');
    }
    return $string;
}

function sku_status($status=0,$comekpty=0)
{
    $string = '<strong style="color:#DB0A0A;">สินค้าตัวนี้หมดหรือไม่สามารถใช้งานได้ชั่วคราว</strong>';
    if($status==1)
        $string = '<strong style="color:#080;">สามารถสั่งซื้อได้</strong>';
    else if($status==2)
        $string = '<strong style="color:#DB0A0A;">สินค้าหมดอายุการขายแล้ว</strong>';
    else if($status==3)
        $string = '<strong style="color:#DB0A0A;">สินค้าตัวนี้หมด หรือ สินค้าตัวอื่นในชุดหมด</strong>';
    else if($status==4)
        $string = '<strong style="color:#DB0A0A;">สินค้าตัวนี้เป็นเฉพาะ สินค้าแลก Promotion เท่านั้น</strong>';
    if( $comekpty == 1)
        $string = '<strong style="color:#DB0A0A;">สินค้าตัวนี้หมด หรือ สินค้าตัวอื่นในชุดหมด</strong>';
    return $string;
}

function get_total_paynow($order_id)
{
    if($order_id <= 0){ return 0.00; }
    
    global $clsSession, $ObjDB;
    
    $query = 'select SUM(`op`.`payment_amount`) as `total_sum`
        ,(`o`.`total` - `o`.`total_discount` - if(`oc`.`discount_price` > 0,`oc`.`discount_price`, 0 ))  as `total`
		,(`o`.`status` ) as `status`
		,(`o`.`payment_type`) as `payment_type`
                ,`oc`.`order_coupon_id` as `coupon_running` , `oc`.`discount_price`
            from  '.T_ORDER.' as `o` 
            left join  '.T_ORDER_PAYMENT.' as `op` on (`o`.`order_id` = `op`.`order_id`)
            left join '.T_ORDER_COUPON.' as `oc` on (`o`.`order_id` = `oc`.`order_id`)
            where `o`.`order_id` = '.$order_id.' 
            group by `o`.`order_id`';
    if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not update product information', '', __LINE__, __FILE__, $query);}
    $tmp = $ObjDB->sql_fetchrow($result);
    
    $tmp['total_sum'] = ($tmp['total_sum']==''?0:$tmp['total_sum']);
    if( $tmp['status'] < 2 )
    {
        $tmp['bt_app'] = false;
    }
    else if($tmp['payment_type']==1)
    {
        $tmp['bt_app'] = false;
    }
    else if($tmp['payment_type']==2 && ($tmp['total_sum']>=$tmp['total']))
    {
        $tmp['bt_app'] = false;
    }
    
    return $tmp;
}

function check_payment($order_id){
    $tmp = get_total_paynow($order_id);
    if(!$tmp['bt_app']){
        return false;
    }else if($tmp['total']==0 || $tmp['total']=='')
        return true;
    return ($tmp['total']<=$tmp['total_sum']);
}

function insert_abs_path($str_replace){
    return unHtmlEntities(str_replace('src=&quot;','src=&quot;'.HOSTNAMEURL,decode_from_db($str_replace)));
}

function get_mail_to_enews($id){
    global $clsSession, $ObjDB;
    $query = 'select * from '.T_ENEWS.' where enews_id = '.$id;
    if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create news information', '', __LINE__, __FILE__, $query);}
        $enew_data = $ObjDB->sql_fetchrow($result);
        
        $temp['subject'] = $enew_data['enews_subject'];
        $temp['body'] = insert_abs_path($enew_data['enews_detail']);
        
        if((bool)$enew_data['normal_con']){
                $condition[] = '`m`.`member_user` !=\'\'';
                $condition[] = '`m`.`member_activate` = 1';
                $condition[] = '`m`.`member_email` != \'\'';
                $condition[] = '`m`.`member_activate_date` != \'\'';
                $condition[] = '`m`.`member_birthday` != \'0000-00-00\'';
                $having = '`AGE` != \'\'';
                
                if(in_array($enew_data['enews_payment_type'],array(1,2))){
                        $condition[] = ($enew_data['enews_payment_type']=='1'?'':'`o`.payment_type = 1');
                        $condition[] = ($enew_data['enews_payment_type']=='2'?'':'`o`.payment_type = 2');}
                if(!empty($enew_data['enews_sel_pcat_id']))
                        $condition[] = '`sku`.`pcat_id` = '.$enew_data['enews_sel_pcat_id'];
                if(!empty($enew_data['enews_sel_psubcat_id']))
                        $condition[] = '`sku`.`ptype_id` = '.$enew_data['enews_sel_psubcat_id'];
                if(!empty($enew_data['enews_sel_brands']))
                        $condition[] = '`sku`.`pbrand_id` = '.$enew_data['enews_sel_brands'];

                if(!empty($enew_data['enews_sel_sex']))
                        $condition[] = '`m`.`member_sex` = '.$enew_data['enews_sel_sex'];

                if($enew_data['enews_title_en']!='1' && $enew_data['enews_title_en']!='')
                        $condition[] = '`sku`.`title_en` = \'%'.$enew_data['enews_title_en'].'%\'';

                if((int)$enew_data['enews_sel_from_age'] < (int)$enew_data['enews_sel_to_age'])
                        $having .= ' AND `AGE` BETWEEN '.(int)$enew_data['enews_sel_from_age'].' AND '.(int)$enew_data['enews_sel_to_age'];

                if(!empty($enew_data['enews_year']))
                        $condition[] = 'YEAR(`o`.`date_archive`) = \''.$enew_data['enews_year'].'\'';
                if(!empty($enew_data['enews_month']))
                        $condition[] = 'MONTH(`o`.`date_archive`) = \''.$enew_data['enews_month'].'\'';
                if(!empty($enew_data['enews_day']))
                        $condition[] = 'DAY(`o`.`date_archive`) = \''.$enew_data['enews_day'].'\'';

                $where = implode(' AND ',$condition);
                $query = '  SELECT `m`.`member_id`, YEAR(CURDATE()) - YEAR(`m`.`member_birthday`) AS `AGE`
                                    , `m`.`member_email`,`m`.`member_user` AS `Name` 
                            FROM '.T_MEMBER.' AS `m`
                            LEFT JOIN '.T_ORDER.' AS `o` ON `o`.`member_id` = `m`.`member_id`
                            LEFT JOIN '.T_PRODUCT_ORDER.' AS `po` ON `po`.`order_id` = `o`.`order_id`
                            LEFT JOIN '.T_PRODUCT_SKU.' AS `sku` ON `sku`.`psku_id` = `po`.`psku_id`
                            WHERE '.$where.'
                            HAVING '. $having;
                $query = ' select trim(member_email) as member_email from '.T_MEMBER;
                if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create news information', '', __LINE__, __FILE__, $query);}
                while($rows = $ObjDB->sql_fetchrow($result)){
                    //$txt[] = $rows['Name'].'-'.$rows['member_email'];
                    if($rows['member_email']!=''){
                            $temp['e_mail'][] = trim($rows['member_email']);
                    
                    }
                }
            
            
        }
        
        
        if((bool)$enew_data['extra_con']){
            // GET an extra mail from enews
                if(!empty($enew_data['enews_addmore'])){
                    $mails = explode(',',$enew_data['enews_addmore']);
                foreach ($mails AS $index => $mail){
                        //$txt[] = '<code class="cHilight2">Extra</code>'.'-'.$mail;
                    if($mail!=''){
                            $temp['e_mail'][] = trim($mail);
                        }
                    }
                }
            
        }
        
        
        if((bool)$enew_data['enews_chk_subscribe']){
                $query = 'SELECT subscribe_email FROM '.T_SUBSCRIBE.' WHERE subscribe_email != \'\'';
                if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create news information', '', __LINE__, __FILE__, $query);}
                while($rows = $ObjDB->sql_fetchrow($result)){
                        //$txt[] = '<code class="cHilight3">Subscribe</code>'.'-'.$rows['subscribe_email'];
                    if($rows['subscribe_email']!=''){
                            $temp['e_mail'][] = trim($rows['subscribe_email']);
                    }
                }
        }
        $temp['e_mail'] = array_unique($temp['e_mail']);
        return $temp;
}

function get_urlbrand($baseUrl){
    global $clsSession;
    
    if(empty($baseUrl))
        return '';

    $tmp = '{Url:\''.$baseUrl.'';
    $type = $clsSession->get_param('type');
    $cat = $clsSession->get_param('cat');
    if(!empty($cat))  $tmp .= '&cat='.$clsSession->get_param('cat').'';
    if(!empty($type))  $tmp .= '&type='.$clsSession->get_param('type').'';
    $tmp .= '\'}';
    return $tmp;
}

function get_urlcat($baseUrl){
    global $clsSession;
    
    if(empty($baseUrl))
        return '';

    $tmp = '{Url:\''.$baseUrl.'';
    $brand = $clsSession->get_param('brand');
    
    if(!empty($brand))  $tmp .= '&brand='.$clsSession->get_param('brand').'';
    $tmp .= '\'}';
    return $tmp;
}

function build_payment_date($data){
    $tmp = (check_date($data['date_payment'])?$data['date_payment']:$data['date_create']);
    return date("j/m/Y",strtotime($tmp));
}

function build_payment_time($data){
    $tmp = (in_array($data['time_payment'],array(':','','00:00'))?date("H:i:s",strtotime($data['date_create'])):$data['time_payment']);
    return $tmp;
}

function check_date($date) {
/*
** check a date
** dd.mm.yyyy || mm/dd/yyyy || dd-mm-yyyy || yyyy-mm-dd 
*/
    if(strlen($date) == 10) {
        $pattern = '/\.|\/|-/i';    // . or / or -
        preg_match($pattern, $date, $char);
        
        $array = preg_split($pattern, $date, -1, PREG_SPLIT_NO_EMPTY); 
        
        if(strlen($array[2]) == 4) {
            // dd.mm.yyyy || dd-mm-yyyy
            if($char[0] == "."|| $char[0] == "-") {
                $month = $array[1];
                $day = $array[0];
                $year = $array[2];
            }
            // mm/dd/yyyy    # Common U.S. writing
            if($char[0] == "/") {
                $month = $array[0];
                $day = $array[1];
                $year = $array[2];
            }
        }
        // yyyy-mm-dd    # iso 8601
        if(strlen($array[0]) == 4 && $char[0] == "-") {
            $month = $array[1];
            $day = $array[2];
            $year = $array[0];
        }
        if(checkdate($month, $day, $year)) {    //Validate Gregorian date
            return TRUE;
        
        } else {
            return FALSE;
        }
    }else {
        return FALSE;    // more or less 10 chars
    }
}

function function_get_point_cal($total){
    if($total>0){
            if($total>get_gold_rate()){
                $tmp['gold_coin'] = floor($total/get_gold_rate()) ;
                $tmp['gold_rate'] = get_gold_rate();
        }
    }
    return $tmp;
}

function get_shipping_at_lion($order_id=0){
    if((int)$order_id<=0)  return '';
    global $ObjDB;
    $query = 'select * from '.T_LION_SHIPPING.' where order_id = '.$order_id;
    
    if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    $tmp = $ObjDB->sql_fetchrow($result);
    $tmp['recieve_date'] = date("Y-m-d",strtotime($tmp['recieve_date']));
    return $tmp;
}

function upload_options($grp_content='') 
{
        global $clsSession;
	$config = $clsSession->get_config('_ALL_');
	$options = array();
	$options['crop_thumb'] = false;
	$options['fit_image'] = false;

	$content_type = array();
	$content_type['IMAGE'] = array(
		'PRODUCT_SKU','HEADER_INVITE', 'HOME_POP','POP_BIRTHDAY');
	$content_type['GALLERY'] = array(
		/*'IR_GALLERY',
		'PROPERTY_GALLERY'*/
	);
	$content_type['ATTACH'] = array(
		'PRODUCT_ATT_1', 'PRODUCT_ATT_2', 'PRODUCT_AUDIO', 'PAYMENT', 'PRODUCT_PAYMENT', 'AFFILIATE_BANNER', 'ARTICLE_ATT_1', 'ARTICLE_AUDIO', 'BANNER', 
		'NEWSLETTER_COMPOSE'
	);
	$content_type['VDO'] = array(
		/*'NEWS_VDO_TH', 'NEWS_VDO_EN', 'IR_VDO'*/
	);

	$grp_content = strtoupper($grp_content);
	$options['prefix'] = false;

	if (in_array($grp_content, $content_type['IMAGE'])) 
        {
		$options['field_name'] = 'Image';
		$options['crop_thumb'] = false;
		$options['fit_image'] = false;
		$options['field_title_name'] = '';
		$options['field_img_id_name'] = '';

		switch ($grp_content) 
                {
				case 'POP_BIRTHDAY':
                                    $options['fit_image']       = false;
                                    $options['re_size']         = true;//Thumb_Width
                                    //$options['create_thump']  = false;
                                    $options['field_name']      = array('image_pop_birthday');
                                    $options['field_dest']      = array(BASEDIR_HOME_POP);
                                    $options['image_width']     = array(160);
                                    $options['image_height']    = array(120);
                                    $options['Crop_Thumb']      = array(false);
                                    $options['Fit_Image']       = array(false);
                                    $options['grp_content'] 	= array('POP_BIRTHDATE');
                                    //$options['thumb_width']   = array(100,400,140);
                                    //$options['thumb_height']  = array(85,160,140);
                                    $options['max_filesize']    = (double)100000000;
                                    //$options['title'] = 'BRAND';

                                    $options['type']  = array('thumbnail');
				break;
				case 'HOME_POP':
                                    $options['fit_image']       = false;
                                    $options['re_size']         = true;//Thumb_Width
                                    //$options['create_thump']  = false;
                                    $options['field_name']      = array('image_home_pop');
                                    $options['field_dest']      = array(BASEDIR_HOME_POP);
                                    $options['image_width']     = array(160);
                                    $options['image_height']    = array(120);
                                    $options['Crop_Thumb']      = array(false);
                                    $options['Fit_Image']       = array(false);
                                    $options['grp_content'] 	= array('HOME_POPUP');
                                    //$options['thumb_width']   = array(100,400,140);
                                    //$options['thumb_height']  = array(85,160,140);
                                    $options['max_filesize']    = (double)100000000;
                                    //$options['title'] = 'BRAND';

                                    $options['type']  = array('thumbnail','image','hotpro','src1','src2','src3','src4');
				break;
				case 'PRODUCT_SKU':
						$options['fit_image']       = true;
						$options['re_size']         = true;
						//$options['create_thump']  = false;
						//$options['field_name']      = array('Image_sku_thumbnail', 'image_image', 'Image_Hot','Image_src1','Image_src2','Image_src3','Image_src4');
                                                $options['field_name']      = array('Image_sku_thumbnail', 'Image_Hot','Image_src1','Image_src2','Image_src3','Image_src4');
						$options['field_dest']      = array(BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU,BASEDIR_PRODUCT_SKU);
						$options['image_width']     = array(160,320,350,350,350,350,350);
						$options['image_height']    = array(120,240,350,350,350,350,350);
						$options['Crop_Thumb']      = array(false,false,false,false,false,false,false);
						$options['Fit_Image']       = array(true,false,false,false,false,false,false);
						//$options['grp_content'] = array(CONTENT_GROUP.'_Thumb', CONTENT_GROUP.'_Image', CONTENT_GROUP.'_Hot', CONTENT_GROUP.'_scr0', CONTENT_GROUP.'_scr1', CONTENT_GROUP.'_scr2', CONTENT_GROUP.'_scr3', CONTENT_GROUP.'_scr4');
                                                $options['grp_content'] = array(CONTENT_GROUP.'_Thumb', CONTENT_GROUP.'_Hot', CONTENT_GROUP.'_scr0', CONTENT_GROUP.'_scr1', CONTENT_GROUP.'_scr2', CONTENT_GROUP.'_scr3', CONTENT_GROUP.'_scr4');
						//$options['thumb_width']     = array(100,400,140);
						//$options['thumb_height']    = array(85,160,140);
						$options['max_filesize']    = (double)100000000;
						//$options['title'] = 'BRAND';
										
						$options['type']  = array('thumbnail','image','hotpro','src1','src2','src3','src4');
				break;
				case 'HEADER_INVITE' :
						$options['fit_image']       = false;
						$options['re_size']         = true;//Thumb_Width
						//$options['create_thump']  = false;
						$options['field_name']      = array('Image_header');
						$options['field_dest']      = array(BASEDIR_HEADER);
						$options['image_width']     = array(160);
						$options['image_height']    = array(120);
						$options['Crop_Thumb']      = array(false);
						$options['Fit_Image']       = array(false);
						$options['grp_content']     = array('header_invite');
										
						//$options['thumb_width']     = array(100,400,140);
						//$options['thumb_height']    = array(85,160,140);
						$options['max_filesize']    = (double)100000000;
						//$options['title'] = 'BRAND';
										
						$options['type']  = array('header_invite');
				break;
                            
                        
			case 'PIC_PROFILE':
				$options['crop_thumb'] = false;
				$options['fit_image'] = true;
				$options['field_name'] = 'pic_profile';
				$options['image_width'] = (int)$config['image_profile_width'];
				$options['image_height'] = (int)$config['image_profile_height'];
				$options['thumb_width'] = (int)$config['image_profile_thumbnail_width'];
				$options['thumb_height'] = (int)$config['image_profile_thumbnail_height'];
				break;

			case 'NEWSLETTER_TEMPLATE_HEADER':
				$options['crop_thumb'] = true;
				$options['fit_image'] = true;
				$options['field_name'] = 'image_header';
				$options['image_width'] = (int)$config['image_newsletter_header_width'];
				$options['image_height'] = (int)$config['image_newsletter_header_height'];
				break;

			case 'NEWSLETTER_TEMPLATE_FOOTER':
				$options['crop_thumb'] = true;
				$options['fit_image'] = true;
				$options['field_name'] = 'image_footer';
				$options['image_width'] = (int)$config['image_newsletter_footer_width'];
				$options['image_height'] = (int)$config['image_newsletter_footer_height'];
				break;

		}

		if (!empty($config['image_extension']) && empty($options['allow_extension'])) {
			$options['allow_extension'] = explode(',', $config['image_extension']);
		}
		if(empty($options['max_filesize'])) $options['max_filesize'] = (int)$config['image_maxsize'];

	} else if (in_array($grp_content, $content_type['ATTACH'])) {
		$options['field_name'] = 'Attach';
		$options['total_upload'] = 1;
		switch ($grp_content) {
			case 'BANNER':
				$options['field_name'] = 'file_banner';
				break;

			case 'NEWSLETTER_COMPOSE':
				$options['field_name'] = 'file_import';
				break;
                        case 'BRAND':
                                $options['allow_extension'] = $options['type'] = $options['field_dest'] = $options['field_name'] = array();
				$options['field_name'] = array('file_brand_logo','file_brand_menu','file_brand_location');
                                $options['field_dest'] = array(BASEDIR_BRAND_LOGO,BASEDIR_BRAND_MENU,BASEDIR_BRAND_LOCATION);
                                $options['type'] = array('logo','menu','location');
                                $options['allow_extension'] = array('jpg','png','gif');
				break;

		}

		if ( $grp_content=='AFFILIATE_BANNER') {
			if (!empty($config['affiliate_banner_extension'])) $options['allow_extension'] = explode(',', $config['affiliate_banner_extension']);
			$options['max_filesize'] = (int)$config['affiliate_banner_maxsize'];

		} else if ( $grp_content=='BANNER') {
			if (!empty($config['banner_extension'])) $options['allow_extension'] = explode(',', $config['banner_extension']);
			$options['max_filesize'] = (int)$config['banner_maxsize'];

		} else if ( $grp_content=='NEWSLETTER_COMPOSE') {
			if (!empty($config['newsletter_import_extension'])) $options['allow_extension'] = explode(',', $config['newsletter_import_extension']);
			$options['max_filesize'] = (int)$config['newsletter_import_maxsize'];
			
		} else if ( $grp_content=='PRODUCT_AUDIO' || $grp_content=='ARTICLE_AUDIO') {
			if (!empty($config['audio_extension'])) $options['allow_extension'] = explode(',', $config['audio_extension']);
			$options['max_filesize'] = (int)$config['audio_maxsize'];
		} else {
			if (!empty($config['attach_extension']) && empty($options['allow_extension']) ) $options['allow_extension'] = explode(',', $config['attach_extension']);
			$options['max_filesize'] = (int)$config['attach_maxsize'];
		}

	} 
		/*$options['field_name'] = array('file_gallery1', 'file_gallery2', 'file_gallery3', 'file_gallery4', 'file_gallery5');
		$options['field_title_name'] = array('title_gallery1', 'title_gallery2', 'title_gallery3', 'title_gallery4', 'title_gallery5');
		$options['image_width'] = (int)$config['gallery_image_width'];
		$options['image_height'] = (int)$config['gallery_image_height'];
		$options['thumb_width'] = (int)$config['gallery_thumbnail_width'];
		$options['thumb_height'] = (int)$config['gallery_thumbnail_height'];
		$options['crop_thumb'] = true;
		$options['crop_image'] = false;
		$options['fit_image'] = false;
		$options['total_upload'] = 1;

		switch ($grp_content) {
			case 'PROPERTY_GALLERY':
				$options['image_width'] = (int)$config['gallery_property_image_width'];
				$options['image_height'] = (int)$config['gallery_property_image_height'];
				break;
		}*/

	

	//$options['max_filesize'] = chkMaxSize((int)$options['max_filesize']);

	return $options;
}

function order_cancel_function_method($order_id){
/*  order_id format 12,14,26,55 or 55  */
if($order_id!=''){
		global $ObjDB;
		$condition = Array();
		$condition[] = ' po.order_id IN ('.$order_id.') ';
		$condition[] = ' po.pay_point > 0 ';
		$condition[] = ' o.member_id > 0 ';
		$condition[] = ' o.order_id > 0 ';
		$strcon = implode(' and ',$condition);
		
		
		$query = 'select (po.pay_point * po.value)  as total_point, o.order_id , o.member_id
		from '.T_PRODUCT_ORDER.' as po 
		left join '.T_ORDER.' as o on  (o.order_id = po.order_id)
		
		where '.$strcon;
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $query);}
		while($data = $ObjDB->sql_fetchrow($result)) {
				if( (int)$data['total_point'] > 0 ){
						$sql = 'update '.T_MEMBER.' as m set m.gold_coin = m.gold_coin + '.(int)$data['total_point'].' where m.member_id = '.(int)$data['member_id'];
						if ( !($sql_query = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $sql);}
					}
			}
		}
}

function re_live_order($order_set){
		/*  order_id format 12,14,26,55 or 55  */
		//exit( "$order_set" );
		if($order_set!=''){
				global $ObjDB;
				$summary_point = 0;
				$condition = Array();
				$condition[] = ' po.order_id IN ('.$order_set.') ';
				$condition[] = ' po.pay_point > 0 ';
				$condition[] = ' o.member_id > 0 ';
				$condition[] = ' o.order_id > 0 ';
				$strcon = implode(' and ',$condition);
				
				
				$query = 'select (po.pay_point * po.value)  as total_point, o.order_id , o.member_id
				from '.T_PRODUCT_ORDER.' as po 
				left join '.T_ORDER.' as o on  (o.order_id = po.order_id)
				
				where '.$strcon;
				if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $query);}
				while($data = $ObjDB->sql_fetchrow($result)) {
						if( (int)$data['total_point'] > 0 )
									$summary_point += (int)$data['total_point'];
									$member_id = (int)$data['member_id'];
				}
						$sql = 'select * from '.T_MEMBER.' as m where m.member_id = '.(int)$member_id;
						if ( !($sql_query = $ObjDB->sql_query($sql)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $sql);}
						$member_data = $ObjDB->sql_fetchrow($sql_query);
						//echo '<pre>'; echo $summary_point;print_r($member_data); exit;
						if( (int)$summary_point > 0 ){
								if( $summary_point <= $member_data['gold_coin'] )
											return true;
								else if( $summary_point > $member_data['gold_coin'] )
											return false;
						}
						return true;
			}
			return false;
}

function birthday_bunus($point_income=0){
		$multiple = 5;
		$point = $point_income * $multiple;
		return (int)$point;
}

function pay_with_point($point_income=0,$order_id=0,$member_id = 0){
		if((int)$order_id <= 0 && (int)$point_income <= 0 && (int)$member_id <= 0) { return ''; }
		global $ObjDB, $clsSession;
		
		$values = Array();
		$values['member_id']    = (int)$member_id;
		$values['ref_id']       = (int)0;
		$values['order_id']     = (int)$order_id;
		$values['action_date']  = 'now()';
		$query = $ObjDB->sql_build('INSERT', T_INVITE, $values);
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query);}
}

function check_sku_over_stock($sku_id = ''){
		
		if(empty($sku_id)) return false;
		global $ObjDB , $clsSession;
		$limit = $clsSession->get_config('Product_Limit');
		
		$query = 'select * ,'.(int)$limit.' as order_limit from '.T_PRODUCT_SKU.' where psku_id in ('.$sku_id.')';
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $query);}
		while($temp = $ObjDB->sql_fetchrow($result)){
				$tmp[$temp['psku_id']] = $temp;
		}
		return $tmp;
}


function checkcomponent_backend($group_com = 0)
{
		if($group_com!=''){
		global $ObjDB;
		
		$comempty = Array();
		$query = 'select `amount`,`psku_id` from '.T_PRODUCT_SKU.' where `psku_id` = ( '.(int)$group_com.' ) ';
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query product speical set component information', '', __LINE__, __FILE__, $query);}
		while( $tmp = $ObjDB->sql_fetchrow($result) ){
				if($tmp['amount']<=0) $comempty[] = 0;

		}
		return	(count($comempty)>0);
    }
	return false;
}

function order_cancel_function_delete_payment($order_id=0){
		if((int)$order_id > 0){
				global $ObjDB;
				$query = 'delete from '.T_ORDER_PAYMENT.' where order_id = '.$order_id;
				if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query products order information', '', __LINE__, __FILE__, $query);}
				return true;
		}else{
				return false;
		}
}

function get_order_from_ordergroup($groupset_id=0,$order_history=true)
{
    global $ObjDB;

	if($groupset_id!=0)
        {
		$query = 'SELECT * ,`oa`.`shipping_aumphur`, `oa`.`shipping_province` , `os`.`shipping_price_manual`, `os`.`shipping_price`,`os`.`shipping_weight_manual`,`o`.`total`';
		$query .= ', CONCAT(`m`.`member_fname`,\'  \',`m`.`member_lname`) AS `name` ,sum((op.pay_point*op.value)) as paywithpoint ';
		$query .= ' FROM '.T_ORDER.' AS `o`';
		$query .= ' LEFT JOIN '.T_MEMBER.' AS `m` ON `o`.`member_id` = `m`.`member_id`';
		$query .= ' LEFT JOIN '.T_ORDER_SHIPPING.' AS `os` ON `os`.`order_id` = `o`.`order_id`';
		$query .= ' LEFT JOIN '.T_ORDER_ADDRESS.' AS `oa` ON `oa`.`order_id` = `o`.`order_id`
                            left join '.T_PRODUCT_ORDER.' as op on o.order_id = op.order_id ';
		$query .= ' WHERE `o`.`shipping_group_id` = '.$groupset_id;
                $query .= ' GROUP BY `o`.`order_id` ';
                
		if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
		
                while( $temp = $ObjDB->sql_fetchrow($result) )
                {
                    if($temp['ro_code']!='')
                    {
                        $temp['order_code'] = $temp['ro_code'];
                    }
                    
                    $temp['po_ro_title'] = 'ใบสั่งซื้อ';
                    if( (bool)$order_history )
                    {
                        $temp['w_user'] = get_order_approveuser((int)$temp['order_id'],1);
                        $temp['new_user'] = get_order_approveuser((int)$temp['order_id'],3);
                        $temp['ship_user'] = get_order_approveuser((int)$temp['order_id'],4);
                    }
                    if( !empty($temp['ro_code']) ){
                        $temp['order_code'] = decode_from_db($temp['ro_code']);
                        $temp['po_ro_title'] = 'ใบแลกของ';
                    }
                    
                    $data[] = $temp;
                }
	}
	return $data;
}

function get_main_caling(){
    global $html;
    $path = $html->get_main_caling();
    return (!empty($path)?$path:default_response);
}

function cancel_promotion($sku_id, $amount, $order_id,$member_id){
        if($sku_id > 0 && $amount > 0 && $order_id > 0){
                global $ObjDB;
                $query = 'update '.T_PRODUCT_SKU.' set amount = (amount + '.(int)$amount.') where psku_id = '.(int)$sku_id.' limit 1 ';
                if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query coupon information', '', __LINE__, __FILE__, $query);}
                
                $values = Array();
		$values['psku_id']      = (int)$sku_id;
		$values['value']        = (int)$amount;
		$values['action']       = 'promotion order cancel';
		$values['date_create']  = 'Now()';
		$values['member_id']    = (int)$member_id;
                $values['order_id']     = (int)$order_id;
                $query = $ObjDB->sql_build('INSERT', T_LOG_STOCK, $values);
		if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not create order information', '', __LINE__, __FILE__, $query);}
                
        }
}

function comparedata($order_id=0){
   if($order_id>0){
       global $ObjDB;
       $query = 'select `order_id`,`psku_id`,`value` AS `quantity`,`price`,(`value`*`price`) AS `total` from '.T_PRODUCT_ORDER.' where `order_id`='.$order_id;
       if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
       while($tmp = $ObjDB->sql_fetchrow($result)){
           $data[$tmp['psku_id']] = $tmp;
       }
   } 
   return $data;
}

function this_user_permistion()
{
    // Top User Permision IS TOP USER
    global $ObjDB,$clsSession;
    $query = 'select user_id,pos_id from '.T_USER.' where user_id = '.(int)$clsSession->get_auth('Id');
    if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Could not query order information', '', __LINE__, __FILE__, $query); }
    $tmp = $ObjDB->sql_fetchrow($result);
    return ($tmp['pos_id']==9);
}

function user_admin_check_menu_permision($menu_id='')
{
    global $clsSession,$ObjDB;
    $admin['Id'] = (int)$clsSession->get_auth('Id');
    $query = 'select * from '.T_USER_PERMISSION.' where user_id = '.(int)$admin['Id'].' and menu like \''.$menu_id.'\' ';
    if ( !($result = $ObjDB->sql_query($query)) ) {message_die(GENERAL_ERROR, 'Could not query user total information', '', __LINE__, __FILE__, $query);}
    $temp = $ObjDB->sql_fetchrow($result);
    $authe = $clsSession->get_value('_SESS_AUTH');
    $pos_id = (int)$authe['pos_id'];
    unset($authe);
    if($menu_id=='user'){
        $temp['action_update'] = 0;
        if($pos_id==9){
            $temp['action_update'] = 1;
        }
    }
    return $temp;
}

function trade_order_paper($type=0,$order_id = 0,$point_with_paid=0)
{
    if((int)$type<=0 || (int)$order_id <= 0 || (int)$point_with_paid == 0 ) { return ''; }
    
    if($type == 1)
    {
        $obj = new trade_order_function();
        return $obj->trade_botton($order_id);
    }
    else if( $type == 2)
    {
        
    }
}

function po_order_paper($type=0,$order_id = 0,$paid_with_money=0,$po_title='')
{
    if((int)$type<=0 || (int)$order_id <= 0 || $paid_with_money <= 0 ) { return ''; }
    
    if($type == 1)
    {
        return '<a href="print_purchase.php?order_id='.$order_id.'" class="btPrint" title=" '.($po_title).' "></a>';
    }
    
}

function ordering_new($ordering=Array(),$prefix='')
{ #Create by ake on 21012557
  
        global $ObjDB;
        $tbl = T_ORDER_TBL;
        $query = '';
        $content = Array();
        foreach($ordering as $index => $item)
        {
            if( (int)$ordering[$index] > 0)
            {
                if( $query == '')
                {
                    $query = ' insert into '.$tbl.' (`psku_id`, `menu`, `ordering`) VALUES ';
                }
                $content[] = ' ( '.(int)$ordering[$index].',\''.$prefix.'\','.(int)$index.') ';
            }
        }
        if(!empty($content))
        {
            $query .= implode(' , ',$content); 
        }
        
        if($query != '')
        { 
            if (!($result = $ObjDB->sql_query($query))) { message_die(GENERAL_ERROR, 'Couldnot query hot promotion information', '', __LINE__, __FILE__, $query);}
        }
}

class editor{
    
    public static function health_editor($name, $width, $height, $toolbarset='', $content='', $required=false){
        global $clsSession;
	require_once(BASEDIR.'/js/ckeditor/ckeditor.php');
        $width = '97%';
	$CKEditor = new CKEditor();
	$CKEditor->basePath = BASEURL.'/js/ckeditor/';
	$CKEditor->returnOutput = true;
	$_SESSION['KCFINDER'] = array();
	$_SESSION['KCFINDER']['disabled'] = false;
	$_SESSION['KCFINDER']['uploadURL'] = HOSTURL.'/uploads/newsletter';
	$_SESSION['KCFINDER']['uploadDir'] = BASEDIR.'/uploads/newsletter';

	$toolbar = array(
		array('Preview','Templates'),
		array('Bold','Italic','Underline','Strike','Link','Unlink','-','Subscript','Superscript','-','RemoveFormat'),
		array('NumberedList','BulletedList','-','Outdent','Indent','Blockquote'),
		array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
		array('TextColor','BGColor'),
		'/',
		array('Styles','Format','Font','FontSize'),
		array('Image','Table','HorizontalRule','Smiley','SpecialChar'),
		array('Source'),
	);

	$config=array(
		"basePath"=>BASEDIR."/js/ckeditor/", //  กำหนด path ของ ckeditor
		"skin"=>"kama", // kama | office2003 | v2
		"language"=>"en", // th / en and more.....
		"extraPlugins"=>"uicolor", // เรียกใช้ plugin ให้สามารถแสดง UIColor Toolbar ได้
		//"uiColor"=>"#92C2C1", // กำหนดสีของ ckeditor
		//"extraPlugins"=>"autogrow", // เรียกใช้ plugin ให้สามารถขยายขนาดความสูงตามเนื้อหาข้อมูล
		"autoGrow_maxHeight"=>400, // กำหนดความสูงตามเนื้อหาสูงสุด ถ้าเนื้อหาสูงกว่า จะแสดง scrollbar
		"enterMode"=>1, // กดปุ่ม Enter -- 1=แทรกแท็ก <p> 2=แทรก <br> 3=แทรก <div>
		"shiftEnterMode"=>1, // กดปุ่ม Shift กับ Enter พร้อมกัน 1=แทรกแท็ก <p> 2=แทรก <br> 3=แทรก <div>
		"height"=>$height, // กำหนดความสูง
		"width"=>$width,  // กำหนดความกว้าง * การกำหนดความกว้างต้องให้เหมาะสมกับจำนวนของ Toolbar
		"filebrowserBrowseUrl"=>BASEURL."/js/ckeditor/kcfinder/browse.php?type=files",
		"filebrowserImageBrowseUrl"=>BASEURL."/js/ckeditor/kcfinder/browse.php?type=image",
		"filebrowserFlashBrowseUrl"=>BASEURL."/js/ckeditor/kcfinder/browse.php?type=flash",
		"filebrowserUploadUrl"=>BASEURL."/js/ckeditor/kcfinder/upload.php?type=files",
		"filebrowserImageUploadUrl"=>BASEURL."/js/ckeditor/kcfinder/upload.php?type=image",
		"filebrowserFlashUploadUrl"=>BASEURL."/js/ckeditor/kcfinder/upload.php?type=flash",
		"toolbar"=>$toolbar,
		"toolbarStartupExpanded"=>true // Show toolbar at startup
	);
	// คืนค่าสำหรับใช้งานร่วมกับ javascript
	$events['instanceReady'] = 'function (evt) { return editorObj=evt.editor; }';

	( (bool)$required ? $CKEditor->textareaAttributes = array("class"=>"editor") : '' ); // if you need to add any class
	return $CKEditor->editor($name, $content, $config, $events);
    }
    
    //public static function Editor(){
        //new editor work on IE10
    //}
    
}

class static_text {
    public static function shipping_text($data=array()){
        global $clsSession;
        //$String = sprintf('ค่าจัดส่งภายในประเทศครั้งละ %s บาท ภายใต้เงื่อนไข %s บาท', 
        //            number_format($data['total_shipping'], 2), 
        //            number_format($data['shipping_rate_condition'], 2));
        $String = 'ค่าจัดส่งภายในประเทศครั้งละ '.number_format($data['total_shipping'], 2).' บาท ภายใต้เงื่อนไข '.number_format($data['shipping_rate_condition'], 2).' บาท';
            return $String;
    } 
    public static function active_text()
    {
        return '<span class="cHilight3"><b>Active</b></span>';
    }
    public static function Inactive_text()
    {
        return '<span class="cError"><b>Inactive</b></span>';
    }
}

class file_management{
        public static function delete_files($dir,$files_name){
                if(!empty($dir) && !empty($files_name)){
                        if( IO::CheckFileExists($dir, $files_name) ){
                                $result = @unlink($dir.'\\'.$files_name);
                        }else{
                            $result = false;
                        }
                }else{
                     $result = false;
                }
                return $result;
        }
}

class product_sku {
    public static function cut_sku_name($sku_name=''){
        return sub_string( html_entity_decode( decode_from_db($sku_name) , ENT_NOQUOTES , "UTF-8") , 40);
    }
    
    public static function reward_product_hot_pro_condition(){
        $Condition = Array();
        $Condition[] = ' p.is_reward_hot = 1';
        $Condition[] = ' p.reward_hot_sale > 0';
        $Condition[] = ' ( curdate() between date(p.reward_hot_active) and date(p.reward_hot_expire) )';
        return implode(' and ',$Condition);
    }
    
    public static function sku_stat_text_check($Content=Array())
    {
            # product_sku::sku_stat_text_check($Content)
            # arr($Content);
            $stat_array = Array();
            if((int)$Content['date_condition']==0)
            {
                $stat_array[] = point_stat_text(1);
            }
            if($Content['published'] == 0)
            {
                $stat_array[] = point_stat_text(2);
            }
            if((int)$Content['stock_amount'] <= 0)
            {
                $stat_array[] = point_stat_text(3);
            }
            if( (int)$Content['point_stat']== 1 )
            {
                $stat_array[] = point_stat_text(4);
            }
            
            if($Content['promotion_active']==1)
            {
                $stat_array[] = point_stat_text(6);
            }
            
            if(!empty($Content['Component']))
            {
                if( (bool)$Content['Component_empty_stock'] )
                {
                    $stat_array[] = point_stat_text(7);
                }
                if( (bool)$Content['Component_inactive'] )
                {
                    $stat_array[] = point_stat_text(8);
                }
            }
            if((int)$Content['pcat_id'] == 7 && empty($Content['Component']))
            {
                $stat_array[] = point_stat_text(9);
            }
            
            if(empty($stat_array))
            {
                $stat_array[] = point_stat_text(5);
            }
            return implode(' <b>และ</b> ',$stat_array);
    }
}

class order_step{
    
    public static function po_or_ro($condition = false,$order_id=0){
        if((int)$order_id > 0){
            if((bool)$condition){
                return '<a href="print_trade.php?order_id='.$order_id.'" class="btPrint" title="ใบแลกสินค้า"></a>';
            }else{
                return '<a href="print_purchase.php?order_id='.$order_id.'" class="btPrint" title="ใบสั่งซื้อ"></a>';
            }
        }else{
            return '';
        }
    }
}

class trade_order_function
{
    function trade_botton($order_id=0)
    {
        if( (int)$order_id <= 0) { return '';}
       
        return '<a href="'.get_link_url(1).'&amp;order_id='.$order_id.'" class="btPrint" title="ใบแลกเปลี่ยนสินค้า"></a>';
    }
}


?>