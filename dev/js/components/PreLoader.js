/*
 * @Author: Thomas Moran 
 * @Date: 2018-07-11 16:22:59 
 * @Last Modified by: Thomas Moran
 * @Last Modified time: 2018-07-12 09:43:10
 */

import React, { Component } from 'react';

export default class PreLoader extends Component {
	render(){
		return(
			<div style={{"height":"100%"}} className="d-flex justify-content-center align-items-center">
				<div className="preloader-lane">
					<div className="preloader-inside"></div>
				</div>
			</div>
		);
	}
}