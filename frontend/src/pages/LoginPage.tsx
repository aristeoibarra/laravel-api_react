import { useState } from 'react';
import { Button, Container, Form } from 'react-bootstrap';

interface ILoginState {
    email: string;
    password: string;
}

export default function LoginPage() {
    const [loginState, setLoginState] = useState<ILoginState>({} as ILoginState);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        console.log(loginState);
    }

    return (
        <Container>
            <h1>Login</h1>
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Label>Email address</Form.Label>
                    <Form.Control type="email" placeholder="name@example.com"
                        onChange={(e) => setLoginState({ ...loginState, email: e.target.value })}
                        value={loginState.email}
                        required
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Password</Form.Label>
                    <Form.Control type="password" placeholder="Password"
                        onChange={(e) => setLoginState({ ...loginState, password: e.target.value })}
                        value={loginState.password}
                        required
                    />
                </Form.Group>


                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form >
        </Container>
    )
}
