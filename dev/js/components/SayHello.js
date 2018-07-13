/*
 * @Author: Thomas Moran 
 * @Date: 2018-07-11 16:23:30 
 * @Last Modified by: Thomas Moran
 * @Last Modified time: 2018-07-11 16:23:52
 */

import React, { Component } from 'react';

export default class SayHello extends Component {
    constructor() {
        super();
        this.state = {
            message: 'Hello World'
        };
    }

	render() {
		return (
            <div>
                {this.state.message}
            </div>
		);
	}
}