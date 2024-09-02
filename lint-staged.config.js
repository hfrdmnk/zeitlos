export default {
    '**/*.php*': ['vendor/bin/duster fix --verbose'],
    'resources/**/*': 'npx prettier --write resources/',
};
