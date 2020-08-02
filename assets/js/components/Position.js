import React, {Component} from 'react';
import axios from 'axios';
import { Container, Row, Col } from 'reactstrap';
    
class Position extends Component {
    
    render() {
        return(
                <div className="position">
                <form>
                    <Container fluid="xs">
                        <Row>
                            <Col>
                                lat
                            </Col>
                            <Col>
                                long
                            </Col>
                        </Row>
                        <Row>
                            <Col>
                                <input className="position" type="number" value={this.props.lat} onChange={this.props.onLatChange} />
                            </Col>
                            <Col>
                                <input className="position" type="number" value={this.props.long} onChange={this.props.onLongChange} />
                            </Col>
                        </Row>
                    </Container>
                </form>
            </div>
        )
    }
}
export default Position;