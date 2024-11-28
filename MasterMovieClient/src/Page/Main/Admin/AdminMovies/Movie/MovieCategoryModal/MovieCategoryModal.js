import Modal from 'react-bootstrap/Modal';
import {Button as ReactButton} from "react-bootstrap";

import './movieModal.css'

import MovieModalDescription from "./../MovieCollectionsModal/MovieModalDescription";
import ButtonClose from "../../../../../../components/Button/ButtonClose";
import Button from "../../../../../../components/Button/Button";
import useMovieCategoryModal from "./useMovieCategoryModal";
import MovieCategoryList from "./MovieCategoryModalList";

const MovieCategoryModal = ({...props}) => {
    const {
        categories,
        handleCategoriesToggle,
        categoriesChecked,
        handleSaveChanges,
        show,
        handleShow,
        handleClose,
    } = useMovieCategoryModal()

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
                Додати до категорії
            </ReactButton>

            <Modal
                show={show}
                onHide={handleClose}
                className="modal-xl movieModal"
            >
                <Modal.Header closeButton className="mainMovieModalBackground">
                    <Modal.Title>Додати до категорії</Modal.Title>
                </Modal.Header>
                <Modal.Body className="mainMovieModalBackground">
                    <div className="movieModalBody">
                        <div>
                            <MovieCategoryList
                                categories={categories}
                                handleCategoriesToggle={handleCategoriesToggle}
                                categoriesChecked={categoriesChecked}
                                // fetchCategories={fetchCategories}
                                // height="100%"
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

export default MovieCategoryModal