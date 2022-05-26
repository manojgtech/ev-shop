const rewire = require("rewire")
const custom = rewire("../custom")
const markitf = custom.__get__("markitf")
// @ponicode
describe("markitf", () => {
    test("0", () => {
        let result = markitf("7289708e-b17a-477c-8a77-9ab575c4b4d8", "array")
        expect(result).toMatchSnapshot()
    })

    test("1", () => {
        let result = markitf("7289708e-b17a-477c-8a77-9ab575c4b4d8", "object")
        expect(result).toMatchSnapshot()
    })

    test("2", () => {
        let result = markitf("03ea49f8-1d96-4cd0-b279-0684e3eec3a9", "string")
        expect(result).toMatchSnapshot()
    })

    test("3", () => {
        let result = markitf("a85a8e6b-348b-4011-a1ec-1e78e9620782", "number")
        expect(result).toMatchSnapshot()
    })

    test("4", () => {
        let result = markitf("03ea49f8-1d96-4cd0-b279-0684e3eec3a9", "number")
        expect(result).toMatchSnapshot()
    })

    test("5", () => {
        let result = markitf("", "")
        expect(result).toMatchSnapshot()
    })
})
