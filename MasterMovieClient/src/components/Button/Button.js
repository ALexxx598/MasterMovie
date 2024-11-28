import {Row, Button as ReactButton} from "react-bootstrap";


const Button = ({...props}) => {

    return (
        <Row className="space3">
            <ReactButton type="submit" variant="success" className="button" onClick={props?.onClick} style={props?.style}>
                {props?.text ?? "Submit"}
            </ReactButton>
        </Row>
    )
}

export default Button