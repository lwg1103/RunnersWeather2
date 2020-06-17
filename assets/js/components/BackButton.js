import React, {Component} from 'react';
import axios from 'axios';
import { Button } from 'reactstrap';
    
class BackButton extends Component {
    
    constructor(props) {
        super(props);
        
        this.runCallback = this.runCallback.bind(this);
    }
    
    runCallback() {
        this.props.callback(this.props.target);
    }
    
    render() {
        return(
            <div>
                <Button outline color="primary" size='sm' onClick={this.runCallback}>Back</Button>
            </div>
        )
    }
}
export default BackButton;