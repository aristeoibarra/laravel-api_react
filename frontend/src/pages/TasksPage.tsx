import { useState } from "react";
import { Container } from "react-bootstrap";

interface ITaskState {
    title: string;
    description: string;
    completed: boolean;
}

export default function TasksPage() {
    const [taskState, setTaskState] = useState<ITaskState>({} as ITaskState);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        console.log(taskState);
    }

    return (
        <Container>
            <h1>Tasks</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="title" className="form-label">Title</label>
                    <input type="text" className="form-control" id="title" placeholder="Title"
                        onChange={(e) => setTaskState({ ...taskState, title: e.target.value })}
                        value={taskState.title}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label htmlFor="description" className="form-label">Description</label>
                    <textarea className="form-control" id="description" rows={3}
                        onChange={(e) => setTaskState({ ...taskState, description: e.target.value })}
                        value={taskState.description}
                        required
                    ></textarea>
                </div>
                <div className="mb-3 form-check">
                    <input type="checkbox" className="form-check-input" id="completed"
                        onChange={(e) => setTaskState({ ...taskState, completed: e.target.checked })}
                        checked={taskState.completed}
                    />
                    <label className="form-check-label" htmlFor="completed">Completed</label>
                </div>

                <button type="submit" className="btn btn-primary">Submit</button>
            </form>
        </Container>
    )
}
