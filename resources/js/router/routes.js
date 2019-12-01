import MyPostsPage from '../pages/MyPostsPage';
import QuestionPage from '../pages/QuestionPage';
import QuestionsPage from '../pages/QuestionsPage';
import NotFoundPage from '../pages/NotFoundPage';
import CreateQuestionPage from '../pages/CreateQuestionPage';
import EditQuestionPage from '../pages/EditQuestionPage.vue'


const routes = [{
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
        path: '/questions/create',
        component: CreateQuestionPage,
        name: 'questions.create'
    },
    {
        path: '/questions/:id/edit',
        component: EditQuestionPage,
        name: 'questions.edit'
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
