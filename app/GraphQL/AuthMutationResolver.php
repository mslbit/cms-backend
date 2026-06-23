<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\ValueObject\AuthResult;
use Maiscraft\Rbac\AuthManager;
use Maiscraft\Rbac\Contract\RbacEngineInterface;
use Maiscraft\Rbac\Contract\GuardInterface;
use Maiscraft\GraphQL\Annotation\Mutation;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Auth Mutation Resolver
 * 登录 mutation 不需要认证（本身就是获取 token 的入口）
 * buildResolver 的认证检查对 login 放行：context 中无 auth_user_id 也可执行
 */
class AuthMutationResolver implements ResolverInterface
{
    protected GuardInterface $guard;

    public function __construct(
        protected AuthManager $authManager,
        protected RbacEngineInterface $rbac
    ) {
        $this->guard = $authManager->guard();
    }

    #[Mutation(description: '管理员登录', auth: false)]
    public function login(string $username, string $password): ?AuthResult
    {
        $token = $this->guard->attemptAndToken([
            'username' => $username,
            'password' => $password,
        ]);

        if ($token === null) {

            return null;
        }

        $user = $this->guard->user();
        if ($user === null) {
            return null;
        }

        $userId = (string) $user->getAuthIdentifier();
        $menus = $this->rbac->getMenus($userId);

        return new AuthResult([
            'token' => $token,
            'user' => [
                'id' => $user->getAuthIdentifier(),
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email ?? null,
            ],
            'menus' => $menus,
        ]);
    }
}