try:
    from urllib.parse import urljoin
except ImportError:
    from urlparse import urljoin

# Third-party imports...
import requests

# Local imports...
from project.constants import BASE_URL

TODOS_URL = "http://localhost/wt2/sign_in.php"


def get_todos():
    response = requests.get(TODOS_URL)
    if response.ok:
        return response
    else:
        return None