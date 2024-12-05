class ActivityController extends Controller
{
    public function process($params)
    {
        $action = $params[0] ?? 'list';

        switch ($action) {
            case 'edit_activity':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activityId'])) {
                    $activityId = $_POST['activityId'];
                    // Lògica per carregar l'activitat
                    $this->twig = 'edit_activity.html';
                }
                break;
            case 'update_activity':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Lògica per actualitzar l'activitat
                    $this->twig = 'edit_activity.html';
                }
                break;
            default:
                $this->twig = 'activity_list.html';
                break;
        }
    }
}