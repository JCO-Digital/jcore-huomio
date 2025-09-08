import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";
import "./editor.scss";

export default function Edit({}) {
  const props = useBlockProps();

  const innerProps = useInnerBlocksProps(props, {
    orientation: "horizontal",
    allowedBlocks: ["jcore/promo-button"],
    template: [["jcore/promo-button", {}]],
  });

  return (
    <>
      <div {...innerProps} />
    </>
  );
}
