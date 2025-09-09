import {
  createRoot,
  StrictMode,
  useEffect,
  useState,
} from "@wordpress/element";
import domReady from "@wordpress/dom-ready";
import apiFetch from "@wordpress/api-fetch";
import {
  Spinner,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
  __experimentalText as Text,
  __experimentalHeading as Heading,
  __experimentalSpacer as Spacer,
  Button,
  Notice,
  ToggleControl,
} from "@wordpress/components";
import { DataForm } from "@wordpress/dataviews/wp";
import { __ } from "@wordpress/i18n";

function Editor() {
  const [toast, setToast] = useState({
    message: "",
  });
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [notice, setNotice] = useState(null);

  useEffect(() => {
    if (notice) {
      setTimeout(() => {
        setNotice(null);
      }, 5000);
    }
  }, [notice]);

  useEffect(async () => {
    try {
      setIsLoading(true);
      const response = await apiFetch({
        path: "/huomio/v1/toast",
      });
      setToast(response);
    } catch (error) {
      console.error(error);
    } finally {
      setIsLoading(false);
    }
  }, []);

  const updateToast = async () => {
    setIsSaving(true);
    try {
      const response = await apiFetch({
        path: "/huomio/v1/toast",
        method: "POST",
        data: { toast },
      });
      setToast(response);
      setNotice({
        message: __("Toast updated", "jcore-huomio"),
        status: "success",
      });
    } catch (error) {
      console.error(error);
      setNotice({
        message: __("Updating toast failed", "jcore-huomio"),
        status: "error",
      });
    } finally {
      setIsSaving(false);
    }
  };

  const fields = [
    {
      label: __("Message", "jcore-huomio"),
      id: "message",
      type: "text",
    },
    {
      label: __("Enabled", "jcore-huomio"),
      id: "enabled",
      type: "integer",
      defaultValue: 0,
      Edit: ({ data, field, onChange }) => {
        const value = field.getValue({ item: data });
        return (
          <ToggleControl
            __nextHasNoMarginBottom
            checked={value === 1}
            label={field.label}
            onChange={(value) =>
              onChange({ ...data, [field.id]: value ? 1 : 0 })
            }
          />
        );
      },
    },
  ];

  const form = {
    layout: {
      type: "regular",
    },
    fields: ["enabled", "message"],
  };

  return (
    <div className="jcore-huomio">
      {notice && (
        <Spacer>
          <Notice status={notice.status} isDismissible={false}>
            <Text>{notice.message}</Text>
          </Notice>
        </Spacer>
      )}
      <Card>
        <>
          <CardHeader>
            <Heading level={3}>{__("Toast settings", "jcore-huomio")}</Heading>
          </CardHeader>
          <CardBody>
            {isLoading && <Spinner />}
            {!isLoading && (
              <DataForm
                data={toast}
                fields={fields}
                form={form}
                onChange={(data) => setToast(data)}
              />
            )}
          </CardBody>
          <CardFooter>
            <Button
              variant="primary"
              onClick={() => updateToast()}
              disabled={isSaving || isLoading}
              isBusy={isSaving}
            >
              {__("Save", "jcore-huomio")}
            </Button>
          </CardFooter>
        </>
      </Card>
    </div>
  );
}

function App() {
  return (
    <StrictMode>
      <Editor />
    </StrictMode>
  );
}

domReady(() => {
  const app = createRoot(document.getElementById("jcore-huomio"));
  app.render(<App />);
});
