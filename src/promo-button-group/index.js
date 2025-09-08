import { registerBlockStyle, registerBlockType } from "@wordpress/blocks";
import "./style.scss";
import Edit from "./edit";
import save from "./save";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: Edit,
  save,
});

registerBlockStyle(metadata.name, {
  name: "gap",
  label: "Gap",
  isDefault: true,
});

registerBlockStyle(metadata.name, {
  name: "no-gap",
  label: "No Gap",
  isDefault: false,
});
