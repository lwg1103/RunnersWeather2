import React, {Component} from 'react';
import axios from 'axios';
import { Button } from 'reactstrap';
    
class CheckButton extends Component {
    
    constructor(props) {
        super(props);
        
        this.state = {props};
        
        this.checkWeather = this.checkWeather.bind(this);
    }
    
    checkWeather() {
        let url = "/api/weather/"+this.props.lat+"/"+this.props.long;
        fetch(url)
            .then(res => res.json())
            .then(
                (result) => {
                    console.log(result);
                },
                (error) => {
                    console.log(error);
                }
            )
    }
    
    render() {
        return(
            <div>
                <Button className="main-btn" color="primary" size="lg" onClick={this.checkWeather}>Check Conditions</Button>
            </div>
        )
    }
}
export default CheckButton;