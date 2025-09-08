import { readFileSync, writeFileSync } from "fs";

try {
  const pluginFileName = "jcore-lohko.php";
  const pack = JSON.parse(readFileSync("package.json"));
  const baseFile = readFileSync(pluginFileName);
  const baseString = baseFile
    .toString()
    .replace(/^(.*)Version:.*$/m, `$1Version: ${pack.version}`);
  writeFileSync(pluginFileName, baseString);
} catch (error) {
  console.error(error);
}
