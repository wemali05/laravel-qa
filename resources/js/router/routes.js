import MyPostsPage from '../pages/MyPostsPage';
import QuestionPage from '../pages/QuestionPage';
import QuestionsPage from '../pages/QuestionsPage';
import NotFoundPage from '../pages/NotFoundPage';


const routes = [
    {
        path: '/',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/my-posts',
        component: MyPostsPage,
        name: 'my-posts',
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/questions/:slug',
        component: QuestionPage,
        name: 'question.show'
    },
    {
        path: '*',
        component: NotFoundPage
    }
]

export default routes
