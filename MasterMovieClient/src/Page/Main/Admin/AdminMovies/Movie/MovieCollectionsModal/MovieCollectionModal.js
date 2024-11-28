import {Col, Row} from "react-bootstrap";

import Modal from 'react-bootstrap/Modal';
import useMovieCollectionModal from "./useMovieCollectionModal";

import './movieModal.css'

import MovieModalDescription from "./MovieModalDescription";
import ButtonClose from "../../../../../../components/Button/ButtonClose";
import Button from "../../../../../../components/Button/Button";
import MovieCollectionList from "./MovieCollectionList";
import {Button as ReactButton} from "react-bootstrap";

const MovieCollectionModal = ({...props}) => {
    const {
        collections,
        handleToggle,
        collectionChecked,
        handleSaveChanges,
        show,
        handleShow,
        handleClose,
    } = useMovieCollectionModal()

    return (
        <>
            <ReactButton
                type="submit"
                variant="success"
                style={{
                    backgroundColor: "#fcba03",
                    borderRadius: 5,
                    color: "black",
                    border: "#fcba03",
                    fontSize: 20,
                    padding: 5,
                }}
                onClick={handleShow}
            >
                Додати до колекції
            </ReactButton>

            <Modal
                show={show}
                onHide={handleClose}
                className="modal-xl movieModal"
            >
                <Modal.Header closeButton className="mainMovieModalBackground">
                    <Modal.Title>Додати до колекцій</Modal.Title>
                </Modal.Header>
                <Modal.Body className="mainMovieModalBackground">
                    <div className="movieModalBody">
                        <div>
                            <MovieCollectionList
                                collections={collections}
                                handleToggle={handleToggle}
                                collectionChecked={collectionChecked}
                                height="100%"
                            />
                        </div>
                        <MovieModalDescription movie={props.movie}/>
                    </div>
                </Modal.Body>
                <Modal.Footer className="mainMovieModalBackground">
                    <Button onClick={handleSaveChanges} text="Зберегти зміни"  style={{
                        borderRadius: 10,
                        backgroundColor: "#e0b12d",
                        color: "black",
                        border: "#e0b12d",
                        fontSize: 20,
                        padding: 5
                    }}/>
                    <ButtonClose onClick={handleClose} text="Скасувати"/>
                </Modal.Footer>
            </Modal>
        </>
    );
}

export default MovieCollectionModal