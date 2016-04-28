<?php

namespace Teller\Web;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\ServiceControllerServiceProvider;

final class ContainerConfiguration implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new ServiceControllerServiceProvider());

        $app['Database'] = $app->share(function() use ($app) {
            return new \PDO(
                'mysql:dbname=' . getenv('BAKSKE_DB') . ';host=' . getenv('BAKSKE_DB_HOST'),
                getenv('BAKSKE_DB_USER'),
                getenv('BAKSKE_DB_PASS')
            );
        });

        $app['RegistrationRepository'] = $app->share(function() use ($app) {
            return new \Teller\Authentication\RegistrationRepositoryPDO($app['Database']);
        });

        $app['SwiftMailer'] = $app->share(function() use ($app) {
            $transport = \Swift_SmtpTransport::newInstance(getenv('BAKSKE_SMTP_HOST'), 465, 'ssl')
                ->setUsername(getenv('BAKSKE_SMTP_USER'))
                ->setPassword(getenv('BAKSKE_SMTP_PASS'))
            ;

            $mailer = \Swift_Mailer::newInstance($transport);

            return $mailer;
        });

        $app['RegistrationNotifier'] = $app->share(function() use ($app) {
            return new \Teller\Authentication\RegistrationNotifierSwiftMailer($app['SwiftMailer']);
        });

        $app['UserRepository'] = $app->share(function() use ($app) {
            return new \Teller\Authentication\UserRepositoryPDO($app['Database']);
        });

        $app['RegistrationService'] = $app->share(function() use ($app) {
            return new \Teller\Authentication\RegistrationService(
                $app['RegistrationRepository'],
                $app['RegistrationNotifier'],
                $app['UserRepository']
            );
        });

        $app['RegistrationController'] = $app->share(function() use ($app) {
            return new RegistrationController($app['RegistrationService']);
        });
    }

    public function boot(Application $app)
    {
    }
}
