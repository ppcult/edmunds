
from tests.testcase import TestCase
from flask.config import Config as FlaskConfig
import os
import mock


class TestConfig(TestCase):
    """
    Test the Config
    """

    def set_up(self):
        """
        Set up the test case
        """

        super(TestConfig, self).set_up()

        random_file = self.rand_str(10)

        # Make config file
        self.config_file = os.path.join(self.app.config.root_path, 'config/%s.py' % random_file)
        self.config_file_txt = os.path.join(self.app.config.root_path, 'config/%s.txt' % random_file)

        # Make env file
        self.env_file = os.path.join(self.app.config.root_path, '.env.py')
        self.env_bak_file = os.path.join(self.app.config.root_path, '.env.%s.py' % random_file)
        if os.path.exists(self.env_file):
            os.rename(self.env_file, self.env_bak_file)

        # Make env testing file
        self.env_testing_file = os.path.join(self.app.config.root_path, '.env.testing.py')
        self.env_testing_bak_file = os.path.join(self.app.config.root_path, '.env.testing.%s.py' % random_file)
        if os.path.exists(self.env_testing_file):
            os.rename(self.env_testing_file, self.env_testing_bak_file)

        # Make env production file
        self.env_production_file = os.path.join(self.app.config.root_path, '.env.production.py')
        self.env_production_bak_file = os.path.join(self.app.config.root_path, '.env.production.%s.py' % random_file)
        if os.path.exists(self.env_production_file):
            os.rename(self.env_production_file, self.env_production_bak_file)

    def tear_down(self):
        """
        Tear down the test case
        """

        super(TestConfig, self).tear_down()

        # Remove config file
        if os.path.exists(self.config_file):
            os.remove(self.config_file)
        if os.path.exists(self.config_file_txt):
            os.remove(self.config_file_txt)

        # Set backup env-file back
        if os.path.exists(self.env_file):
            os.remove(self.env_file)
        if os.path.exists(self.env_bak_file):
            os.rename(self.env_bak_file, self.env_file)

        # Set backup env-testing-file back
        if os.path.exists(self.env_testing_file):
            os.remove(self.env_testing_file)
        if os.path.exists(self.env_testing_bak_file):
            os.rename(self.env_testing_bak_file, self.env_testing_file)

        # Set backup env-production-file back
        if os.path.exists(self.env_production_file):
            os.remove(self.env_production_file)
        if os.path.exists(self.env_production_bak_file):
            os.rename(self.env_production_bak_file, self.env_production_file)

    def test_config_file(self):
        """
        Test config file
        """

        old_format = [
            "GOT_SON                    = 'Jon Snow 3' \n",
            "GOT_GIRL                   = 'Igritte 3' \n",
            "GOT_ENEMY                  = ('The', 'White', 'Walkers', 3) \n",
            "GOT_WINTER_IS_COMING_TO    = 'Town 3'"
        ]

        new_format = [
            "GOT = { \n",
            "   'son':      'Jon Snow 3', \n",
            "   'girl':     'Igritte 3', \n",
            "   'enemy':    ('The', 'White', 'Walkers', 3), \n",
            "   'winter': { \n",
            "       'is': { \n",
            "           'coming': { \n",
            "               'to': 'Town 3' \n",
            "           }, \n",
            "       }, \n",
            "   }, \n",
            "} \n",
        ]

        data = [
            ('got.son',                     'Jon Snow 3',                       ),
            ('got.girl',                    'Igritte 3',                        ),
            ('got.enemy',                   ('The', 'White', 'Walkers', 3),     ),
            ('got.winter.is.coming.to',     'Town 3'                            ),
        ]

        # Check each format
        for format in (old_format, new_format):

            # Make config file
            if os.path.isfile(self.config_file):
                os.remove(self.config_file)
            with open(self.config_file, 'w+') as f:
                f.writelines(format)

            # Make app
            app = self.create_application()

            # Check config
            for row in data:
                key, value = row

                self.assert_true(app.config.has(key))
                self.assert_equal(value, app.config(key))

    def test_env_file(self):
        """
        Test env file
        """

        old_format = [
            "GOT_SON                    = 'Jon Snow 4' \n",
            "GOT_GIRL                   = 'Igritte 4' \n",
            "GOT_ENEMY                  = ('The', 'White', 'Walkers', 4) \n",
            "GOT_WINTER_IS_COMING_TO    = 'Town 4'"
        ]

        new_format = [
            "GOT = { \n",
            "   'son':      'Jon Snow 4', \n",
            "   'girl':     'Igritte 4', \n",
            "   'enemy':    ('The', 'White', 'Walkers', 4), \n",
            "   'winter': { \n",
            "       'is': { \n",
            "           'coming': { \n",
            "               'to': 'Town 4' \n",
            "           }, \n",
            "       }, \n",
            "   }, \n",
            "} \n",
        ]

        data = [
            ('got.son',                     'Jon Snow 4',                       ),
            ('got.girl',                    'Igritte 4',                        ),
            ('got.enemy',                   ('The', 'White', 'Walkers', 4),     ),
            ('got.winter.is.coming.to',     'Town 4'                            ),
        ]

        # Check each format
        for format in (old_format, new_format):

            # Make config file
            if os.path.isfile(self.env_file):
                os.remove(self.env_file)
            with open(self.env_file, 'w+') as f:
                f.writelines(format)

            # Make app
            app = self.create_application()

            # Check config
            for row in data:
                key, value = row

                self.assert_true(app.config.has(key))
                self.assert_equal(value, app.config(key))

    def test_env_testing_file(self):
        """
        Test env testing file
        """

        old_format = [
            "GOT_SON                    = 'Jon Snow 5' \n",
            "GOT_GIRL                   = 'Igritte 5' \n",
            "GOT_ENEMY                  = ('The', 'White', 'Walkers', 5) \n",
            "GOT_WINTER_IS_COMING_TO    = 'Town 5'"
        ]

        new_format = [
            "GOT = { \n",
            "   'son':      'Jon Snow 5', \n",
            "   'girl':     'Igritte 5', \n",
            "   'enemy':    ('The', 'White', 'Walkers', 5), \n",
            "   'winter': { \n",
            "       'is': { \n",
            "           'coming': { \n",
            "               'to': 'Town 5' \n",
            "           }, \n",
            "       }, \n",
            "   }, \n",
            "} \n",
        ]

        data = [
            ('got.son',                     'Jon Snow 5',                       ),
            ('got.girl',                    'Igritte 5',                        ),
            ('got.enemy',                   ('The', 'White', 'Walkers', 5),     ),
            ('got.winter.is.coming.to',     'Town 5'                            ),
        ]

        # Check each format
        for format in (old_format, new_format):

            # Make config file
            if os.path.isfile(self.env_testing_file):
                os.remove(self.env_testing_file)
            with open(self.env_testing_file, 'w+') as f:
                f.writelines(format)

            # Make app
            app = self.create_application()

            # Check config
            for row in data:
                key, value = row

                self.assert_true(app.config.has(key))
                self.assert_equal(value, app.config(key))

    def test_env_testing_test_file(self):
        """
        Test env testing test file
        """

        old_format = [
            "GOT_SON                    = 'Jon Snow 6' \n",
            "GOT_GIRL                   = 'Igritte 6' \n",
            "GOT_ENEMY                  = ('The', 'White', 'Walkers', 6) \n",
            "GOT_WINTER_IS_COMING_TO    = 'Town 6'"
        ]

        new_format = [
            "GOT = { \n",
            "   'son':      'Jon Snow 6', \n",
            "   'girl':     'Igritte 6', \n",
            "   'enemy':    ('The', 'White', 'Walkers', 6), \n",
            "   'winter': { \n",
            "       'is': { \n",
            "           'coming': { \n",
            "               'to': 'Town 6' \n",
            "           }, \n",
            "       }, \n",
            "   }, \n",
            "} \n",
        ]

        data = [
            ('got.son',                     'Jon Snow 6',                       ),
            ('got.girl',                    'Igritte 6',                        ),
            ('got.enemy',                   ('The', 'White', 'Walkers', 6),     ),
            ('got.winter.is.coming.to',     'Town 6'                            ),
        ]

        # Check each format
        for format in (old_format, new_format):

            # Make config file
            self.write_config(format)

            # Make app
            app = self.create_application()

            # Check config
            for row in data:
                key, value = row

                self.assert_true(app.config.has(key))
                self.assert_equal(value, app.config(key))

    def test_merging_and_priority(self):
        """
        Test merging and priority of config
        """

        # Make env testing test file
        self.write_config([
            "GOT = { \n",
            "   'son': 'Jon Snow 7', \n",
            "   'priority': { \n",
            "       'first': 1, \n",
            "   } \n",
            "} \n",
        ])

        # Make env testing file
        with open(self.env_testing_file, 'w+') as f:
            f.writelines([
                "GOT = { \n",
                "   'girl': 'Igritte 7', \n",
                "   'priority': { \n",
                "       'first': 2, \n",
                "       'second': 2, \n",
                "   } \n",
                "} \n",
            ])

        # Make env file
        with open(self.env_file, 'w+') as f:
            f.writelines([
                "GOT = { \n",
                "   'enemy': ('The', 'White', 'Walkers', 7), \n",
                "   'priority': { \n",
                "       'first': 3, \n",
                "       'second': 3, \n",
                "       'third': 3, \n",
                "   } \n",
                "} \n",
            ])

        # Make config file
        with open(self.config_file, 'w+') as f:
            f.writelines([
                "GOT = { \n",
                "   'weapon': 'Dragon Glass 7', \n",
                "   'priority': { \n",
                "       'first': 4, \n",
                "       'second': 4, \n",
                "       'third': 4, \n",
                "       'fourth': 4, \n",
                "   } \n",
                "} \n",
            ])

        data = [
            ('got.son',                 'Jon Snow 7',                   ),
            ('got.girl',                'Igritte 7',                    ),
            ('got.enemy',               ('The', 'White', 'Walkers', 7), ),
            ('got.weapon',              'Dragon Glass 7',               ),
            ('got.priority.first',      1,                              ),
            ('got.priority.second',     2,                              ),
            ('got.priority.third',      3,                              ),
            ('got.priority.fourth',     4,                              ),
        ]

        # Make app
        app = self.create_application()

        # Check config
        for row in data:
            key, value = row

            self.assert_true(app.config.has(key), msg=key)
            self.assert_equal(value, app.config(key), msg=key)

    def test_file_priority(self):
        """
        Test priority of config
        """

        key = 'got.season'
        old_key = 'GOT_SEASON'

        # Make config file
        with open(self.config_file, 'w+') as f:
            f.write("%s = %d" % (old_key, 1))

        # Make app
        app = self.create_application()

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(1, app.config(key))
        self.assert_equal(1, app.config[old_key])

        # Make env file
        with open(self.env_file, 'w+') as f:
            f.write("%s = %d" % (old_key, 2))

        # Make app
        app = self.create_application()

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(2, app.config(key))
        self.assert_equal(2, app.config[old_key])

        # Make env testing file
        with open(self.env_testing_file, 'w+') as f:
            f.write("%s = %d" % (old_key, 3))

        # Make app
        app = self.create_application()

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(3, app.config(key))
        self.assert_equal(3, app.config[old_key])

        # Make env testing test file
        self.write_config("%s = %d" % (old_key, 4));

        # Make app
        app = self.create_application()

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(4, app.config(key))
        self.assert_equal(4, app.config[old_key])

    def test_setting_environment(self):
        """
        Test setting the environment
        """

        value = 'nice'
        str_value = "'nice'"
        key = 'got.niveau'
        old_key = 'GOT_NIVEAU'

        # Make env file
        with open(self.env_production_file, 'w+') as f:
            f.write("%s = %s\n" % (old_key, str_value))

        # Make app
        app = self.create_application(environment='production')

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(value, app.config(key))
        self.assert_equal(value, app.config[old_key])

    def test_non_py_config_file(self):
        """
        Testing non-python config file
        :return:    void
        """

        # Make config file
        with open(self.config_file_txt, 'w+') as f:
            f.writelines([
                "GOT = { \n",
                "   'son': 'Jon Snow 1', \n",
                "   'girl': 'Igritte 1', \n",
                "   'enemy': ('The', 'White', 'Walkers', 1), \n",
                "   'weapon': 'Dragon Glass 1', \n",
                "} \n",
            ])

        data = [
            ('got.son',                 'GOT_SON',              'Jon Snow 1',                   ),
            ('got.girl',                'GOT_GIRL',             'Igritte 1',                    ),
            ('got.enemy',               'GOT_ENEMY',            ('The', 'White', 'Walkers', 1), ),
            ('got.weapon',              'GOT_WEAPON',           'Dragon Glass 1',               ),
        ]

        # Make app
        app = self.create_application()

        # Check config
        for row in data:
            key, old_key, value = row

            self.assert_false(app.config.has(key))
            self.assert_is_none(app.config(key))
            self.assert_not_in(old_key, app.config)

    def test_failed_config_load(self):
        """
        Test failed config load
        :return:    void
        """

        key = 'got.season'
        old_key = 'GOT_SEASON'

        # Make config file
        with open(self.config_file, 'w+') as f:
            f.write("%s = %d" % (old_key, 1))

        # Make app
        app = self.create_application()

        # Check config
        self.assert_true(app.config.has(key))
        self.assert_equal(1, app.config(key))
        self.assert_equal(1, app.config[old_key])

        # Make app
        with mock.patch.object(FlaskConfig, 'from_pyfile', return_value=False):
            app = self.create_application()

            # Check config
            self.assert_false(app.config.has(key))
            self.assert_is_none(app.config(key))
            self.assert_not_in(old_key, app.config)

    def test_env_no_environment(self):
        """
        Test no environment is set
        :return:    void
        """

        with self.assert_raises_regexp(RuntimeError, 'environment'):
            self.create_application('')

    def test_functionality(self):
        """
        Test functionality
        :return:    void
        """

        # Write config
        self.write_config([
            "APP_INFO_NAME = 'name' \n",
            "APP = { \n",
            "   'info': { \n",
            "       'artist': 'artist', \n",
            "       'list': [ \n",
            "           'value1', \n",
            "           'value2', \n",
            "       ], \n",
            "       'none': None, \n",
            "       'name': 'othername', \n",
            "   }, \n",
            "   'INFO_ADDRESS': 'address' \n",
            "} \n",
            "SQLALCHEMY_DATABASE_URI = 'uri'"
        ])

        # Create app
        app = self.create_application()

        # Check
        default_value = self.rand_str(20)
        get_data = [
            ('app.info', {'artist': 'artist', 'list': ['value1', 'value2'], 'none': None, 'name': 'othername'}),
            ('app.info.name', 'name'),
            ('app.info.artist', 'artist'),
            ('app.info.list.0', 'value1'),
            ('app.info.list.1', 'value2'),
            ('app.info.list', ['value1', 'value2']),
            ('app.info.none', None),
            ('sqlalchemy.database.uri', 'uri'),

            ('APP_INFO', {'artist': 'artist', 'list': ['value1', 'value2'], 'none': None, 'name': 'othername'}),
            ('APP_INFO_NAME', 'name'),
            ('APP_INFO_ARTIST', 'artist'),
            ('APP_INFO_LIST_0', 'value1'),
            ('APP_INFO_LIST_1', 'value2'),
            ('APP_INFO_LIST', ['value1', 'value2']),
            ('APP_INFO_NONE', None),
            ('SQLALCHEMY_DATABASE_URI', 'uri'),
        ]
        for key, expected in get_data:
            self.assert_equal(expected != default_value, app.config.has(key))
            self.assert_equal_deep(expected, app.config(key, default_value))

        self.assert_in('INFO_ADDRESS', app.config('app'))
        self.assert_equal_deep('address', app.config('app')['INFO_ADDRESS'])

        # Update
        app.config['APP_INFO_ANOTHER'] = 'value'
        self.assert_true(app.config.has('app.info.another'))
        self.assert_equal_deep('value', app.config('app.info.another'))

        # Delete
        del app.config['APP_INFO_ANOTHER']
        self.assert_false(app.config.has('app.info.another'))
        self.assert_equal_deep(None, app.config('app.info.another'))

        # Curious exception
        self.assert_true(app.config.has('app.info.name'))
        self.assert_equal_deep('name', app.config('app.info.name'))
        # Delete priority which then returns other value
        del app.config['APP_INFO_NAME']
        self.assert_true(app.config.has('app.info.name'))
        self.assert_equal_deep('othername', app.config('app.info.name'))
        # Delete other value
        del app.config['APP']['info']['name']
        self.assert_false(app.config.has('app.info.name'))
