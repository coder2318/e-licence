<?php

namespace App\Http\Controllers\V1;

use App\Integrations\Base\Exceptions\ClientError;
use App\Integrations\Base\Exceptions\ConnectionException;
use App\Integrations\Base\Exceptions\ServerException;
use App\Integrations\Base\Exceptions\TimeoutException;
use App\Integrations\Base\Exceptions\UnknownError;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Services\OneIdService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;

class OneIdController extends AuthController implements AuthInterface
{
    protected string $url;
    protected string $client_id;
    protected string $redirect_url;
    protected string $scope;
    protected string $state;

    public function __construct(protected OneIdService $service)
    {
        $this->url = config('integrations.oneID.url');
        $this->client_id = config('integrations.oneID.client_id');
        $this->redirect_url = config('integrations.oneID.redirect_uri');
        $this->scope = config('integrations.oneID.redirect_uri');
        $this->state = config('integrations.oneID.state');
    }

    public function redirect(): RedirectResponse
    {
        $redirectUrl = $this->url . "?response_type=one_code&client_id=$this->client_id&redirect_uri=$this->redirect_url&scope=$this->scope&state=$this->state";
        return redirect($redirectUrl);
    }

    /**
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws UnknownError
     * @throws JsonException
     * @throws ClientError
     * @throws ServerException
     * @throws GuzzleException
     */
    public function callback(Request $request): RedirectResponse
    {
        if ($request->has('code')) {
            $data = $this->service->userData($request->all());
            return $this->userLogin($data);

        }
        return back();
    }

    public function userLogin($params): RedirectResponse
    {
//        if(!$params['isJuridic'])
//            abort(403,'Faqat Yuridik shaxs kira oladi');

        /** @var User $user */
        $user = $this->service->checkRegister($params);
        $this->service->getRole($user, User::ROLE_USER);

        if ($this->authenticate($user)) {
            return redirect()->route('application.index');
        }
        return back()->with(['error']);
    }

    public function adminLogin($params): RedirectResponse
    {
        /** @var User $user */
        $user = $this->service->checkRegister($params);
        $this->service->getRole($user, User::ROLE_ADMIN);

        if ($this->authenticate($user)) {
            return redirect()->route('dashboard');
        }
        return back()->with(['error']);
    }

}
