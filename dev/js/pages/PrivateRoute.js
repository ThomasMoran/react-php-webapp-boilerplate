/*
 * @Author: Thomas Moran 
 * @Date: 2018-07-11 16:45:09 
 * @Last Modified by: Thomas Moran
 * @Last Modified time: 2018-07-11 17:51:16
 */

import React, { Component } from "react";
import { Route, Redirect, withRouter } from "react-router-dom";
import $ from 'jquery';

class PrivateRoute extends Component {
	constructor(props) {
		super(props);

        var me = this;
        var hasAuthBeenChecked = false;

        this.token = $('#session-token').val();

        $.ajax({
            method: 'POST',
            data: {
                token: this.token,
                action: 'checkLoggedIn'
            },
            url: 'process.php',
            success: function(res) {
                if(res === 'true') {
                    me.props.setLoggedOut();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
	}

	render() {
        const {component: Component, ...rest} = this.props;
        return (
            <Route {...rest} render={ props =>
                this.props.isLoggedIn ? ( <Component {...this.props} /> ) : (
                    <Redirect
                        to={{
                            pathname: "/"
                        }}
                    />
                )
            }/>
        )
	}
}

export default withRouter(PrivateRoute);