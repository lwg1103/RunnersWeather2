import React, {Component} from 'react';
import axios from 'axios';
import GoogleMapReact from 'google-map-react';

class Map extends Component {

    constructor(props) {
        super(props);

        this.state = {props};
    }

    render() {
        return(
                <div className="map" style={{height: '50vh', width: '100%'}}>
                    <GoogleMapReact
                        bootstrapURLKeys={{key: "AIzaSyAJWgwdS-Luy3s1l40AvBPlHfZGdsV0rk4"}}
                        defaultCenter={{lat: 1, long: 1}}
                        center={{lat: this.props.lat, long: this.props.long}}
                        defaultZoom={11}
                        onGoogleApiLoaded={({map, maps}) => console.log(map, maps)}
                        yesIWantToUseGoogleMapApiInternals
                        >
                    </GoogleMapReact>
                </div>
                )
    }
}
export default Map;