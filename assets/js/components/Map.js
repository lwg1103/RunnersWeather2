import React, {Component} from 'react';
import axios from 'axios';
import GoogleMapReact from 'google-map-react';

const XMarker = ({ text }) => <div>{text}</div>;

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
                        defaultCenter={{lat: 1, lng: 1}}
                        center={{lat: parseFloat(this.props.lat), lng: parseFloat(this.props.long)}}
                        defaultZoom={14}
                        >
                        <XMarker
                            lat={parseFloat(this.props.lat)}
                            lng={parseFloat(this.props.long)}
                            text="X"
                            />
                    </GoogleMapReact>
                </div>
                )
    }
}
export default Map;