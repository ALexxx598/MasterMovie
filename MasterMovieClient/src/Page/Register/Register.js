import 'bootstrap/dist/css/bootstrap.min.css';
import './register.css'
import '../../components/button.css'
import {Col, Container, Row} from "react-bootstrap";
import {useRegister} from "./useRegister";
import Button from "../../components/Button/Button";
import {LOGIN, DOMAIN} from "../../Routes";

const Register = () => {
    const { formik, preRegister } = useRegister()

    return (
        <div className="registerBackground">
            <Container>
                <Row className="align-content-center align-items-center justify-content-center">
                    {/*<Col xs={12} md={8}><img src={require("../../assets/images/logo.png")}/></Col>*/}
                    <Col  md={4} className="formColumn">
                        <Row className="signIn">
                            <Col md={{ offset: 1 }}>Sign In</Col>
                            <Col md={{ offset: 1 }}><a href={DOMAIN + LOGIN}>Увійти</a></Col>
                        </Row>
                        <form onSubmit={formik.handleSubmit} >
                            <Row>
                                <Col>
                                    <label htmlFor="firstName" className="labelPadding">Ім'я</label>
                                    <input
                                        id="firstName"
                                        name="firstName"
                                        type="text"
                                        onChange={formik.handleChange}
                                        value={formik.values.firstName}
                                        className={ !formik.errors.firstName
                                            ? "form-control"
                                            : "form-control inputBottomBorder"
                                        }
                                    />
                                    {
                                        formik.errors.firstName
                                            ? <span className="formikError">{formik.errors.firstName}</span>
                                            : null
                                    }
                                </Col>
                                <Col>
                                    <label htmlFor="lastName" className="labelPadding">Прізвище</label>
                                    <input
                                        id="lastName"
                                        name="lastName"
                                        type="text"
                                        onChange={formik.handleChange}
                                        value={formik.values.lastName}
                                        className={ !formik.errors.lastName
                                            ? "form-control"
                                            : "form-control inputBottomBorder"
                                        }
                                    />
                                    {
                                        formik.errors.lastName
                                            ? <span className="formikError">{formik.errors.lastName}</span>
                                            : null
                                    }
                                </Col>
                            </Row>
                            <Row className="space3">
                                <label htmlFor="email" className="labelPadding">Адрес електронної пошти</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    onChange={formik.handleChange}
                                    value={formik.values.email}
                                    className={ !formik.errors.email
                                        ? "form-control"
                                        : "form-control inputBottomBorder"
                                    }
                                />
                                {
                                    formik.errors.email
                                        ? <span className="formikError">{formik.errors.email}</span>
                                        : null
                                }
                            </Row>
                            <Row className="space3">
                                <label htmlFor="password" className="labelPadding">Пароль</label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    onChange={formik.handleChange}
                                    value={formik.values.password}
                                    className={ !formik.errors.password ? "form-control" : "form-control inputBottomBorder"}
                                />
                                {
                                    formik.errors.password
                                        ? <span className="formikError">{formik.errors.password}</span>
                                        : null
                                }
                            </Row>
                            <Row className="space3">
                                <label htmlFor="passwordConfirmation" className="labelPadding">Підтвердження паролю</label>
                                <input
                                    id="passwordConfirmation"
                                    name="passwordConfirmation"
                                    type="password"
                                    onChange={formik.handleChange}
                                    value={formik.values.passwordConfirmation}
                                    className={ !formik.errors.passwordConfirmation
                                        ? "form-control"
                                        : "form-control inputBottomBorder"
                                    }
                                />
                                {
                                    formik.errors.passwordConfirmation
                                        ? <span className="formikError">{formik.errors.passwordConfirmation}</span>
                                        : null
                                }
                            </Row>
                            {
                                preRegister
                                    ?  <Row className="space3">
                                        <label htmlFor="registerCode" className="labelPadding">Реєстраційний код</label>
                                        <input
                                            id="registerCode"
                                            name="registerCode"
                                            type="registerCode"
                                            onChange={formik.handleChange}
                                            value={formik.values.registerCode}
                                            className={ !formik.errors.registerCode
                                                ? "form-control"
                                                : "form-control inputBottomBorder"
                                            }
                                        />
                                        {
                                            formik.errors.registerCode
                                                ? <span className="formikError">{formik.errors.registerCode}</span>
                                                : null
                                        }
                                    </Row>
                                    : null
                            }
                            <Button type="submit" variant="success" className="button"  style={{
                                borderRadius: 10,
                                backgroundColor: "#e0b12d",
                                color: "black",
                                border: "#e0b12d",
                                fontSize: 20,
                                padding: 5
                            }}text="Зареєструватися"/>
                        </form>
                    </Col>
                </Row>
            </Container>
        </div>
    );
}

export default Register