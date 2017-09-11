
from edmunds.localization.translations.exceptions.translationerror import TranslationError
from edmunds.localization.translations.exceptions.sentencefillererror import SentenceFillerError


class TranslatorWrapper(object):

    def __init__(self, app, translator, localization, localization_fallback):
        """
        Constructor
        :param app:                     The application
        :type app:                      edmunds.application.Application
        :param translator:              The translator-driver
        :type translator:               edmunds.localization.translations.drivers.basedriver.BaseDriver
        :param localization:            The localization
        :type localization:             edmunds.localization.localization.models.localization.Localization
        :param localization_fallback:   The fallback localization
        :type localization_fallback:    edmunds.localization.localization.models.localization.Localization
        """

        self.app = app
        self.translator = translator
        self.localization = localization
        self.localization_fallback = localization_fallback

    def get(self, key, parameters=None):
        """
        Get translation
        :param key:         Key of translation
        :type key:          str
        :param parameters:  Parameters used to complete the translation
        :type parameters:   dict
        :return:            The translation
        :type:              str
        """

        try:
            return self.translator.get(self.localization, key, parameters=parameters)
        except TranslationError as e:
            self.app.logger.error(e)
        except SentenceFillerError as e:
            self.app.logger.error(e)

        return self.translator.get(self.localization_fallback, key, parameters=parameters)