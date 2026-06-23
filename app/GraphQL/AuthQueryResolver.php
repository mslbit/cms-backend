<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\ValueObject\AuthResult;
use Maiscraft\Rbac\AuthManager;
use Maiscraft\Rbac\Contract\RbacEngineInterface;
use Maiscraft\Rbac\Contract\GuardInterface;
use Maiscraft\GraphQL\Annotation\Query;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Auth Query Resolver
 * me 查询通过 token 参数认证（非 HTTP 中间件方式）
 */
class AuthQueryResolver implements ResolverInterface
{
    protected GuardInterface $guard;

    public function __construct(
        protected AuthManager $authManager,
        protected RbacEngineInterface $rbac
    ) {
        $this->guard = $authManager->guard();
    }

    #[Query(description: '获取当前用户信息和菜单')]
    public function me(string $token): ?AuthResult
    {
        /** JwtGuard 手动解码 token（非中间件场景） */
        if (!method_exists($this->guard, 'decodeToken')) {
            return null;
        }

        $userId = $this->guard->decodeToken($token);
        if ($userId === null) {
            return null;
        }

        $user = $this->guard->getProvider()->retrieveById($userId);
        if ($user === null) {
            return null;
        }

        $menus = $this->rbac->getMenus((string) $userId);

        return new AuthResult([
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