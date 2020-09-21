import React, {Component} from 'react';
import {Route, Switch, Redirect, Link, withRouter} from 'react-router-dom';
import Map from './Map';
import Position from './Position';
import CheckButton from './CheckButton';
import BackButton from './BackButton';
import Screen from '../dict/Screen';

class Home extends Component {

    constructor(props) {
        var registration;

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
        this.updatePosition = this.updatePosition.bind(this);
        this.savePosition = this.savePosition.bind(this);
        this.showNotification = this.showNotification.bind(this);

        this.updatePosition();

        this.registerNotification();
        this.scheduleBackgroundSync();
    }

    async registerNotification()
    {
        this.registration = await navigator.serviceWorker.getRegistration();
    }

    async scheduleBackgroundSync()
    {
        if (!navigator.serviceWorker) {
            return console.error("Service Worker not supported")
        }

        navigator.serviceWorker.ready
                .then(registration => registration.sync.register('sync-weather'))
                .then(() => console.log("Registered background sync"))
                .catch(err => console.error("Error registering background sync", err));
    }

    showNotification(text, timestamp)
    {
        Notification.requestPermission().then(permission => {
            if (permission !== 'granted') {
                alert('you need to allow push notifications');
            } else {
                this.registration.showNotification(text);
            }
        });
    }

    updatePosition()
    {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(this.savePosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    savePosition(position) {
        this.setState({
            lat: (position.coords.latitude).toFixed(5),
            long: (position.coords.longitude).toFixed(5),
        })
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
        this.setState({
            conditions: result,
            screen: Screen.RecommendationDetails
        });
        this.showNotification("Weather for running: " + this.state.conditions.decision.name);
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
                    <Map lat={this.state.lat} long={this.state.long} /> 
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
                    <p>Time: {this.state.conditions.datetime.date}</p>
                </div>
                )
    }
}

export default Home;