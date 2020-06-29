import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
import Map from './Map';
import Position from './Position';
import CheckButton from './CheckButton';
import BackButton from './BackButton';
import Screen from '../dict/Screen';

class Home extends Component {
    
    constructor(props) {
        super(props);
        this.state = {
            long: 17.05629,
            lat: 51.08613,
            screen: Screen.Home
        };

        this.handleLatChange = this.handleLatChange.bind(this);
        this.handleLongChange = this.handleLongChange.bind(this);
        this.handleWeatherConditionsChange = this.handleWeatherConditionsChange.bind(this);
        this.navigateTo = this.navigateTo.bind(this);
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
    
    handleWeatherConditionsChange(result) {
        console.log('cond change', result);
        this.setState({
            conditions: result,
            screen: Screen.RecommendationDetails
        });
    }
    
    navigateTo(screen) {
        this.setState({
            screen: screen
        })
    }
    
    render() {
        switch (this.state.screen) {
            case Screen.Home:
                return this.renderHome();
            case Screen.RecommendationDetails:
                return this.renderRecommendationDetails();
            
        }
    }
    
    renderHome() {
        return (
           <div>
               <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                   <Link className={"navbar-brand"} to={"/"}> Runners Weather 2.0 </Link>
               </nav>
                <Map /> 
                <Position lat={this.state.lat} long={this.state.long} onLatChange={this.handleLatChange} onLongChange={this.handleLongChange}/>
                <CheckButton lat={this.state.lat} long={this.state.long} onSuccess={this.handleWeatherConditionsChange}/>
           </div>
        )
    }
    
    renderRecommendationDetails() {
        return (
           <div>
               <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                   <Link className={"navbar-brand"} to={"/"}> Runners Weather 2.0 </Link>
               </nav>
               <BackButton callback={this.navigateTo} target={Screen.Home}/>
               <p>PM 2.5: {this.state.conditions.pm25}</p>
               <p>PM 10: {this.state.conditions.pm10}</p>
               <p>Temp: {this.state.conditions.temperature} 'C</p>
               <p>Weather: {this.state.conditions.type.name}</p>
               <p>Wind: {this.state.conditions.wind} m/s</p>
               <p>Humidity: {this.state.conditions.humidity} %</p>
               <p>Decision: {this.state.conditions.decision.name}</p>
           </div>
        )
    }
}
    
export default Home;