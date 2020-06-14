import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
import Map from './Map';
import Position from './Position';
import CheckButton from './CheckButton';

class Home extends Component {
    
    constructor(props) {
        super(props);
        this.state = {
            long: 1.0,
            lat: 1.0
        };

        this.handleLatChange = this.handleLatChange.bind(this);
        this.handleLongChange = this.handleLongChange.bind(this);
    }
      
    handleLatChange(event) {
        this.setState({
            lat: event.target.value,
        });
    }
    
    handleLongChange(event) {
        this.setState({
            long: event.target.value
        });
    }
    
    render() {
        return (
           <div>
               <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                   <Link className={"navbar-brand"} to={"/"}> Runners Weather 2.0 </Link>
               </nav>
               <Map /> 
               <Position lat={this.state.lat} long={this.state.long} onLatChange={this.handleLatChange} onLongChange={this.handleLongChange}/>
               <CheckButton lat={this.state.lat} long={this.state.long}/>
           </div>
        )
    }
}
    
export default Home;