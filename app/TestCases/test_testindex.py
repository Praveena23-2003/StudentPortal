from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class TestTestindex():
    def setup_method(self, method):
        self.driver = webdriver.Chrome()
        self.vars = {}

    def teardown_method(self, method):
        self.driver.quit()

    def test_testindex(self):
        self.driver.get("http://localhost:8000/")
        self.driver.set_window_size(1072, 816)
        self.driver.find_element(By.LINK_TEXT, "Login").click()

        # Wait for the "Register" link to be clickable
        wait = WebDriverWait(self.driver, 10)
        register_link = wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "Register")))

        # Click on the "Register" link
        register_link.click()

        # Continue with the rest of your test steps
