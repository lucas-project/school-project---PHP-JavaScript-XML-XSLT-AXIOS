<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules
         syntax recommendation http://www.w3.org/TR/xslt
    -->
    <xsl:template match="/">
        <h2> Shopping Cart</h2>
        <table border="1">

                <tr>
                    <th>Item number</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Remove</th>
                </tr>

            <tbody id="tblCart">
                <xsl:for-each select="/cart/item">
                    <xsl:variable name="itemNo" select="id"/>
                    <tr>
                        <td>
                            <xsl:value-of select="id"/>
                        </td>
                        <td>
                            $<xsl:value-of select="price"/>
                        </td>
                        <td>
                            <xsl:value-of select="quantity"/>
                        </td>
                        <td>
                            <button class="btn-sm btn btn-primary" onclick="removeItemFromCart({$itemNo});">Remove from cart</button>
                        </td>
                    </tr>
                </xsl:for-each>
                <tr class="alert alert-success">
                    <td colspan="3"><span class="">Total:</span></td>
                    <td  name="totalP"><xsl:value-of select="/cart/total"/></td>
                </tr>
                <tr>
                    <td colspan="2"><button class="btn btn-success" onclick="confirmPurchase();">Confirm Purchase</button></td>
                    <td colspan="2"><button class="btn btn-danger" onclick="cancelPurchase();">Cancel Purchase</button></td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript" src="buying.js">&#160;</script>
    </xsl:template>

</xsl:stylesheet>
