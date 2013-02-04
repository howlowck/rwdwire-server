<?php
$config = array( 
			'photo_edit' => array(
				array(
					'field' => 'rank',
					'label' => 'Ordering',
					'rules' => 'required'
				)
			),
			'halls_new' => array(
				array(
					'field' => 'uid',
					'label' => 'Unique ID',
					'rules' => 'trim|required|integer|is_unique[halls.uid]'
				),
				array(
					'field' => 'name',
					'label' => 'Hall Name',
					'rules' => 'trim|required'
				)
			),
			'amenities_new' => array(
				array(
					'field'=>'amen_name',
					'label'=>'Amenity',
					'rules'=>'trim|required|is_unique[amenities.name]'
				)
			) 
		);