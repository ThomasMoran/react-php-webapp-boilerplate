/*
 * @Author: Thomas Moran 
 * @Date: 2018-07-11 16:22:49 
 * @Last Modified by: Thomas Moran
 * @Last Modified time: 2018-08-16 16:47:14
 */

// ========= Dependencies =========
import React, { Component } from 'react';
import $ from 'jquery';

// ========= Components =========
// import SayHello from '../components/SayHello';
// import PreLoader from '../components/PreLoader';
import { Link } from 'react-router-dom';

export default class Home extends Component {
    constructor() {
        super();
        this.state = {
            message: 'Hello World'
        };

        this.registerCompany = this.registerCompany.bind(this);
    }

    registerCompany() {
        $.ajax({
            method: 'POST',
            data: {
                token: this.props.token,
                action: 'registerCompany',
                data: JSON.stringify({name: 'ian', email: '', address: '', password: ''})
            },
            url: 'process.php',
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            }
        });
    }

	render() {
		return (
            <div>
                {/* <SayHello /> */}
                
                <div>
                    <Link to="/pl">
                        <span style={{"height":"20px","width":"50px", "backgroundColor":"green", "display":"inline-block"}}></span>
                    </Link>
                    <Link to="/secret-page">
                        <span style={{"height":"20px","width":"50px", "backgroundColor":"red", "display":"inline-block"}}></span>
                    </Link>
                    <span style={{"height":"20px","width":"50px", "backgroundColor":"blue", "display":"inline-block"}} onClick={this.registerCompany}></span>
                </div>
            </div>
		);
	}
}